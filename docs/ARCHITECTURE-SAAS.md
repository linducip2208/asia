# System Architecture — SaaS Multi-Tenant
## ERPAsia — White Label Retail Commerce Platform

---

## 1. Multi-Tenant Architecture

### Strategy: Shared Database + Shared Schema dengan Tenant Scoping

```
┌─────────────────────────────────────────────────────────────────────┐
│                    SAAS ARCHITECTURE OVERVIEW                        │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  ┌─────────────────────────────────────────────────────────────┐   │
│  │                    SUPER ADMIN PANEL                          │   │
│  │                    (/super)                                    │   │
│  │  • Tenant Management    • Subscription Plans                  │   │
│  │  • Billing & Invoices   • White Label Config                  │   │
│  │  • System Monitoring    • Feature Toggle                      │   │
│  └──────────────────────────┬──────────────────────────────────┘   │
│                             │                                       │
│  ┌──────────────────────────┼──────────────────────────────────┐   │
│  │                    MIDDLEWARE LAYER                           │   │
│  │  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌────────────┐   │   │
│  │  │ Identify │  │ Resolve  │  │ Tenant   │  │ Feature    │   │   │
│  │  │ Tenant   │─▶│ Tenant   │─▶│ Scope    │─▶│ Gate       │   │   │
│  │  │ (domain) │  │ Model    │  │ (global) │  │ (toggle)   │   │   │
│  │  └──────────┘  └──────────┘  └──────────┘  └────────────┘   │   │
│  └──────────────────────────┬──────────────────────────────────┘   │
│                             │                                       │
│         ┌───────────────────┼───────────────────┐                  │
│         ▼                   ▼                   ▼                    │
│  ┌────────────┐  ┌──────────────┐  ┌──────────────────┐           │
│  │ TENANT A   │  │ TENANT B     │  │ TENANT C         │           │
│  │ Dashboard  │  │ Dashboard    │  │ Dashboard        │           │
│  │ /admin     │  │ /admin       │  │ /admin           │           │
│  │ (scoped)   │  │ (scoped)     │  │ (scoped)         │           │
│  └────────────┘  └──────────────┘  └──────────────────┘           │
│                                                                     │
│  ┌─────────────────────────────────────────────────────────────┐   │
│  │                    DATA ISOLATION                             │   │
│  │  Semua query: WHERE tenant_id = auth()->user()->tenant_id    │   │
│  │  Global scopes di setiap model Tenant-aware                  │   │
│  │  File storage: storage/tenants/{tenant_id}/...               │   │
│  └─────────────────────────────────────────────────────────────┘   │
│                                                                     │
└─────────────────────────────────────────────────────────────────────┘
```

---

## 2. Tenant Resolution Flow

### 2.1 Resolution Methods (Priority Order)

| Priority | Method | Example | Use Case |
|---|---|---|---|
| 1 | Subdomain | `tenant-a.erpasia.test` | Production multi-tenant |
| 2 | Custom Domain | `tokoberkah.com` | White label |
| 3 | X-Tenant-ID Header | `X-Tenant-ID: 1` | API / internal |
| 4 | Session | `tenant_id` in session | After login |

### 2.2 Middleware Pipeline

```php
app/Http/Middleware/Tenant/IdentifyTenant.php     → detect domain/subdomain
app/Http/Middleware/Tenant/ResolveTenant.php      → find Tenant model
app/Http/Middleware/Tenant/ScopeTenantData.php    → set global scope
```

### 2.3 Tenant Model

```php
// app/Models/Tenant.php
class Tenant extends Model
{
    protected $fillable = [
        'name', 'slug', 'domain', 'custom_domain',
        'logo_url', 'favicon_url', 'primary_color',
        'subscription_plan_id', 'subscription_ends_at',
        'status',     // active, suspended, trial, expired
        'settings',   // JSON: tax, currency, timezone, language, etc.
    ];

    protected $casts = [
        'settings' => 'array',
        'subscription_ends_at' => 'datetime',
    ];

    public function users(): HasMany { ... }
    public function outlets(): HasMany { ... }
    public function subscriptionPlan(): BelongsTo { ... }
    public function subscriptionInvoices(): HasMany { ... }
}
```

---

## 3. Global Tenant Scope

### 3.1 Trait for Tenant-Aware Models

```php
// app/Models/Traits/BelongsToTenant.php
trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::creating(function ($model) {
            if (!$model->tenant_id && auth()->check()) {
                $model->tenant_id = auth()->user()->tenant_id;
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            if (auth()->check() && auth()->user()->tenant_id) {
                $builder->where('tenant_id', auth()->user()->tenant_id);
            }
        });
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
```

### 3.2 Tenant-Aware Models (Semua model di bawah tenant)
```
products, categories, brands, units, outlets, customers,
suppliers, orders, payments, purchase_orders, stock_movements,
users, roles, settings, dll.
```

### 3.3 Global Models (non-tenant, Super Admin only)
```
tenants, subscription_plans, subscription_invoices,
announcements, support_tickets, coupons
```

---

## 4. Super Admin Architecture

### 4.1 Super Admin Panel (`/super`)

```
┌─────────────────────────────────────────────────────────────────────┐
│                    SUPER ADMIN PANEL                                 │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  Filament Panel ID: 'super'                                         │
│  Path: /super                                                       │
│  Auth Guard: web (users dengan role 'super_admin')                  │
│                                                                     │
│  NAVIGATION:                                                        │
│  ┌───────────────────────────────────────────────────────────────┐ │
│  │ 🏢 TENANTS                                                    │ │
│  │  ├── Daftar Tenant (list + filter status)                     │ │
│  │  ├── Tenant Baru (create + assign plan)                       │ │
│  │  └── Detail Tenant (info, subscription, usage)               │ │
│  │                                                                │ │
│  │ 💳 SUBSCRIPTION                                               │ │
│  │  ├── Subscription Plans (CRUD + feature matrix)               │ │
│  │  ├── Active Subscriptions                                     │ │
│  │  ├── Billing & Invoices                                       │ │
│  │  ├── Payments                                                 │ │
│  │  └── Coupons (CRUD)                                           │ │
│  │                                                                │ │
│  │ 🎨 WHITE LABEL                                                │ │
│  │  ├── Theme Presets                                            │ │
│  │  └── Domain Mapping                                           │ │
│  │                                                                │ │
│  │ 📢 COMMUNICATION                                              │ │
│  │  ├── Announcements (broadcast)                                │ │
│  │  └── Support Tickets                                          │ │
│  │                                                                │ │
│  │ 📊 MONITORING                                                 │ │
│  │  ├── System Dashboard (MRR, churn, growth)                    │ │
│  │  ├── Tenant Usage (API calls, storage, users)                 │ │
│  │  ├── AI Usage                                                 │ │
│  │  └── System Logs                                              │ │
│  │                                                                │ │
│  │ ⚙️ SYSTEM                                                     │ │
│  │  ├── Feature Toggle                                           │ │
│  │  ├── License Management                                       │ │
│  │  └── Audit Log (global)                                       │ │
│  └───────────────────────────────────────────────────────────────┘ │
│                                                                     │
└─────────────────────────────────────────────────────────────────────┘
```

### 4.2 Super Admin Panel Provider

```php
// app/Providers/Filament/SuperPanelProvider.php
class SuperPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('super')
            ->path('super')
            ->login()
            ->brandName('ERPAsia Super Admin')
            ->colors(['primary' => Color::Indigo])
            ->navigationGroups([
                '🏢 Tenants',
                '💳 Subscription',
                '🎨 White Label',
                '📢 Communication',
                '📊 Monitoring',
                '⚙️ System',
            ])
            ->resources([
                TenantResource::class,
                SubscriptionPlanResource::class,
                SubscriptionResource::class,
                BillingInvoiceResource::class,
                CouponResource::class,
                AnnouncementResource::class,
                SupportTicketResource::class,
                FeatureToggleResource::class,
            ])
            ->pages([
                SuperDashboard::class,
                TenantUsage::class,
                SystemLogs::class,
            ])
            ->widgets([
                SuperStatsOverview::class,
                MrrChart::class,
                TenantGrowthChart::class,
            ]);
    }
}
```

---

## 5. Subscription System Architecture

### 5.1 Plan Feature Matrix

```php
// app/Models/SubscriptionPlan.php
class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name',           // Free, Starter, Professional, Business, Enterprise
        'slug',
        'price_monthly',  // in IDR
        'price_yearly',
        'price_lifetime',
        'max_outlets',
        'max_users',
        'max_products',
        'max_transactions_per_day',
        'features',       // JSON: array of enabled features
        'is_active',
    ];

    protected $casts = [
        'price_monthly' => 'integer',
        'price_yearly' => 'integer',
        'price_lifetime' => 'integer',
        'features' => 'array',
    ];
}
```

### 5.2 Feature Toggle Architecture

```php
// app/Services/FeatureToggleService.php
class FeatureToggleService
{
    public function isEnabled(string $feature, ?Tenant $tenant = null): bool
    {
        $tenant ??= current_tenant();
        $plan = $tenant->subscriptionPlan;
        return in_array($feature, $plan->features ?? []);
    }

    // Usage in Blade:
    // @feature('manufacturing')
    //   <x-manufacturing-menu />
    // @endfeature

    // Usage in Filament:
    // NavigationItem::make('Produksi')
    //     ->visible(fn() => feature_enabled('manufacturing'));
}
```

### 5.3 Subscription Lifecycle

```
┌────────────┐     ┌────────────┐     ┌──────────────┐     ┌──────────────┐
│ Register   │────▶│ Trial      │────▶│ Active       │────▶│ Expired      │
│ (Free)     │     │ (14 hari)  │     │ (Paid Plan)  │     │ (Grace 3d)   │
└────────────┘     └────────────┘     └──────┬───────┘     └──────┬───────┘
                                              │                    │
                                              │  Upgrade/          │  No payment
                                              │  Downgrade         │  after grace
                                              ▼                    ▼
                                       ┌────────────┐     ┌──────────────┐
                                       │ New Plan   │     │ Suspended    │
                                       │ Active     │     │ (30 days)    │
                                       └────────────┘     └──────┬───────┘
                                                                  │
                                                                  ▼
                                                           ┌──────────────┐
                                                           │ Terminated   │
                                                           │ (Data purged)│
                                                           └──────────────┘
```

### 5.4 Billing Cycle

| Plan | Renewal | Prorated |
|---|---|---|
| Monthly | Every 30 days | Yes (upgrade/downgrade mid-cycle) |
| Yearly | Every 365 days | Yes |
| Lifetime | Once | N/A |
| Custom | As defined | Yes |

---

## 6. Application Layer Architecture

### 6.1 Directory Structure (SaaS Update)

```
laravel/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       ├── Tenant/                      # Tenant-specific commands
│   │       │   ├── EvaluateSubscriptions.php
│   │       │   ├── CheckExpiredTenants.php
│   │       │   └── AutoBackupPerTenant.php
│   │       └── Super/                        # Super admin commands
│   │           ├── GenerateMonthlyReport.php
│   │           └── CleanExpiredData.php
│   │
│   ├── Enums/
│   │   ├── TenantStatus.php          # active, suspended, trial, expired
│   │   ├── SubscriptionStatus.php    # active, grace, expired, cancelled
│   │   └── FeatureToggle.php         # semua feature flags
│   │
│   ├── Filament/
│   │   ├── Resources/
│   │   │   ├── TenantResource.php
│   │   │   ├── ... (existing resources)
│   │   ├── Pages/
│   │   │   ├── SuperDashboard.php
│   │   │   └── ... (existing pages)
│   │   └── Widgets/
│   │       └── ... (existing + new)
│   │
│   ├── Http/
│   │   ├── Middleware/
│   │   │   ├── Tenant/
│   │   │   │   ├── IdentifyTenant.php      # dari domain/subdomain/header
│   │   │   │   ├── ResolveTenant.php       # lookup tenant model
│   │   │   │   └── ScopeTenantData.php     # set global scope
│   │   │   ├── FeatureGate.php             # feature toggle check
│   │   │   └── SubscriptionCheck.php       # check active subscription
│   │   └── Controllers/
│   │       ├── Super/                       # Super admin controllers
│   │       │   ├── TenantController.php
│   │       │   ├── SubscriptionController.php
│   │       │   └── BillingController.php
│   │       ├── Tenant/                      # Tenant-facing controllers
│   │       │   ├── RegisterController.php
│   │       │   ├── OnboardingController.php
│   │       │   └── WhiteLabelController.php
│   │       └── Api/V1/                      # (existing, unchanged)
│   │
│   ├── Models/
│   │   ├── Tenant.php                       # NEW
│   │   ├── SubscriptionPlan.php            # NEW
│   │   ├── SubscriptionInvoice.php         # NEW
│   │   ├── Coupon.php                       # NEW
│   │   ├── Announcement.php                # NEW
│   │   ├── SupportTicket.php               # NEW
│   │   ├── Traits/
│   │   │   └── BelongsToTenant.php         # NEW - global scope trait
│   │   └── ... (existing models → add BelongsToTenant trait)
│   │
│   ├── Providers/
│   │   ├── Filament/
│   │   │   ├── AdminPanelProvider.php       # Tenant admin panel
│   │   │   └── SuperPanelProvider.php       # NEW - Super admin panel
│   │   ├── TenantServiceProvider.php       # NEW - tenant bootstrapping
│   │   └── ... (existing providers)
│   │
│   └── Services/
│       ├── TenantService.php               # NEW - tenant CRUD + onboarding
│       ├── SubscriptionService.php         # NEW - billing + invoice
│       ├── FeatureToggleService.php        # NEW - feature check
│       ├── WhiteLabelService.php           # NEW - domain, theme, logo
│       └── ... (existing services)
│
├── database/
│   └── migrations/
│       ├── 2026_07_09_000001_create_tenants_table.php
│       ├── 2026_07_09_000002_add_tenant_id_to_all_tables.php
│       ├── 2026_07_09_000003_create_subscription_plans_table.php
│       ├── 2026_07_09_000004_create_subscription_invoices_table.php
│       ├── 2026_07_09_000005_create_coupons_table.php
│       ├── 2026_07_09_000006_create_announcements_table.php
│       └── 2026_07_09_000007_create_support_tickets_table.php
│
├── resources/
│   └── views/
│       ├── tenant/                          # Tenant-facing views
│       │   ├── register.blade.php           # Registration form
│       │   ├── onboarding.blade.php          # Setup wizard
│       │   └── plans.blade.php               # Plan selection
│       └── super/                           # (via Filament)
│
├── routes/
│   ├── tenant.php                           # NEW - tenant routes
│   ├── super.php                            # NEW - super admin routes
│   └── web.php                              # (existing, updated)
│
└── tests/
    ├── Feature/
    │   ├── TenantIsolationTest.php          # NEW
    │   ├── SubscriptionTest.php             # NEW
    │   └── ... (existing + new)
    └── Unit/
        ├── TenantScopeTest.php              # NEW
        └── FeatureToggleTest.php            # NEW
```

---

## 7. Event-Driven Architecture

### 7.1 Key Events

```
┌──────────────────────────────────────────────────────────────────────┐
│                    EVENT MAP                                          │
├──────────────────────────────────────────────────────────────────────┤
│                                                                      │
│  TENANT LIFECYCLE                                                    │
│  ────────────────                                                    │
│  TenantRegistered → SendWelcomeEmail → CreateDefaultOutlet           │
│  TenantSubscribed → ActivateTenant → SetupDefaultSettings            │
│  SubscriptionExpiring → SendReminder (7d, 3d, 1d before)            │
│  SubscriptionExpired → MoveToGracePeriod → NotifyOwner               │
│  SubscriptionSuspended → DisableAccess → NotifyOwner                 │
│                                                                      │
│  BUSINESS LOGIC                                                      │
│  ──────────────                                                      │
│  OrderCompleted → UpdateStock → CalculateCommision → CreateJournal   │
│  StockMovementCreated → CheckLowStock → SendAlert                    │
│  PaymentReceived → UpdateInvoice → SendReceipt                       │
│  ProductionCompleted → UpdateInventory → RecordWaste                 │
│                                                                      │
│  NOTIFICATIONS                                                       │
│  ─────────────                                                       │
│  LowStockDetected → NotifyManager (in-app + WA + email)              │
│  ExpiryWarning → NotifyManager                                       │
│  ApprovalNeeded → NotifyApprovers                                     │
│  PaymentDue → NotifyTenantOwner                                      │
│                                                                      │
└──────────────────────────────────────────────────────────────────────┘
```

### 7.2 Event Registration

```php
// app/Providers/EventServiceProvider.php
protected $listen = [
    // Tenant
    TenantRegistered::class => [
        SendWelcomeEmail::class,
        CreateDefaultOutlet::class,
    ],
    TenantSubscribed::class => [
        ActivateTenant::class,
        GenerateFirstInvoice::class,
    ],
    SubscriptionExpiring::class => [
        SendExpiryReminder::class,
    ],

    // Business
    OrderCompleted::class => [
        UpdateProductStock::class,
        CalculateLoyaltyPoints::class,
        CreateJournalEntry::class,
        SendOrderNotification::class,
    ],
    StockMovementCreated::class => [
        UpdateStockSummary::class,
        CheckLowStockThreshold::class,
    ],

    // Finance
    PaymentReceived::class => [
        UpdateInvoiceStatus::class,
        SendPaymentReceipt::class,
    ],
    JournalEntryCreated::class => [
        UpdateAccountBalance::class,
    ],
];
```

---

## 8. Queue & Scheduler Architecture

### 8.1 Queue Jobs

```
┌──────────────────────────────────────────────────────────────────────┐
│                    QUEUE JOBS                                         │
├──────────────────────────────────────────────────────────────────────┤
│                                                                      │
│  HIGH PRIORITY (default queue)                                       │
│  • ProcessPayment                                                    │
│  • GenerateInvoice                                                   │
│  • SendNotification (transactional)                                  │
│                                                                      │
│  NORMAL PRIORITY                                                     │
│  • ExportReport (PDF/Excel)                                          │
│  • GenerateReceipt                                                   │
│  • CalculateCommission                                               │
│  • EvaluateMembershipTier                                            │
│                                                                      │
│  LOW PRIORITY                                                        │
│  • SyncMarketplaceProducts                                           │
│  • CleanExpiredTokens                                                │
│  • ArchiveAuditLogs                                                  │
│  • GenerateBackup                                                    │
│                                                                      │
└──────────────────────────────────────────────────────────────────────┘
```

### 8.2 Scheduler (routes/console.php)

```
┌──────────────────────────────────────────────────────────────────────┐
│                    SCHEDULER SCHEDULE                                 │
├──────────────┬──────────────┬────────────────────────────────────────┤
│ Frequency    │ Command      │ Description                            │
├──────────────┼──────────────┼────────────────────────────────────────┤
│ everyMinute  │ queue:work   │ Process pending queue jobs             │
│ hourly       │ notify:low   │ Check low stock → send alerts          │
│              │ stock        │                                        │
│ hourly       │ notify:expiry│ Check expiring products → send alerts  │
│ every 5 min  │ notify:send  │ Send pending notifications            │
│ daily 08:00  │ notify:      │ Send H-1 return + invoice due alerts  │
│              │ reminders    │                                        │
│ daily 02:00  │ backup:db    │ Database backup per tenant             │
│ daily 02:45  │ seo:indexnow │ IndexNow submission                    │
│ daily 03:00  │ seo:google   │ Google Indexing API                    │
│ daily 00:00  │ membership:  │ Evaluate membership tier upgrade/      │
│              │ evaluate     │ downgrade                              │
│ daily 00:30  │ stock:       │ Force close open shifts               │
│              │ close-shift  │                                        │
│ weekly mon   │ report:      │ Generate weekly sales summary          │
│ 08:00        │ weekly       │                                        │
│ monthly 1st  │ commission:  │ Calculate monthly sales commission     │
│ 00:30        │ calculate    │                                        │
│ monthly 1st  │ report:      │ Generate monthly financial report      │
│ 02:00        │ monthly      │                                        │
│ daily 01:00  │ subscription │ Check expired subscriptions           │
│              │ :evaluate    │ → move to grace/suspend                │
│ daily 02:30  │ clean:old    │ Clean expired tokens, old sync logs    │
│              │ data         │                                        │
└──────────────┴──────────────┴────────────────────────────────────────┘
```

---

## 9. Security Architecture

### 9.1 Multi-Tenant Security Layers

```
┌──────────────────────────────────────────────────────────────────────┐
│                    SECURITY LAYERS                                    │
├──────────────────────────────────────────────────────────────────────┤
│                                                                      │
│  LAYER 1: AUTHENTICATION                                             │
│  • Sanctum SPA Cookie (admin/portal)                                 │
│  • Sanctum API Token (Flutter app)                                   │
│  • Password: Bcrypt hashed, min 8 chars                              │
│  • 2FA optional (per tenant config)                                  │
│                                                                      │
│  LAYER 2: TENANT ISOLATION                                            │
│  • Global Scope: WHERE tenant_id = current_tenant_id()               │
│  • Middleware: SubscriptionCheck (pastikan subscription active)      │
│  • Custom Domain: validasi CNAME record                              │
│                                                                      │
│  LAYER 3: AUTHORIZATION (RBAC)                                       │
│  • Spatie/laravel-permission                                        │
│  • Role: super_admin, owner, manager, admin, kasir, gudang           │
│  • Permission: granular per modul                                    │
│  • Outlet Scope: user hanya lihat data outlet yang di-assign         │
│                                                                      │
│  LAYER 4: FEATURE GATE                                              │
│  • Feature Toggle per tenant/plan                                    │
│  • Middleware: FeatureGate::class                                    │
│  • Blade: @feature('manufacturing')                                  │
│                                                                      │
│  LAYER 5: RATE LIMITING                                              │
│  • API: 60 req/min per token                                         │
│  • Login: 5 req/min per IP                                           │
│  • Registration: 3 req/hour per IP                                   │
│                                                                      │
│  LAYER 6: AUDIT TRAIL                                                │
│  • Semua CRUD: who, what, when, old, new                             │
│  • Immutable: tidak bisa dihapus                                     │
│  • Retention: 2 tahun                                                │
│                                                                      │
└──────────────────────────────────────────────────────────────────────┘
```

---

## 10. Scaling Strategy

### 10.1 Growth Phases

| Phase | Tenants | Strategy |
|---|---|---|
| **MVP** | 1–50 | Single server, MySQL, no Redis |
| **Growth** | 50–500 | Add Redis cache, DB read replica |
| **Scale** | 500–5.000 | Load balancer + multiple app servers, DB sharding (by tenant) |
| **Enterprise** | 5.000+ | Microservices for heavy modules (reports, sync), CDN, queue cluster |

### 10.2 Current Phase (MVP): Single Server Architecture

```
┌──────────────────────────────────────────────────────────────────────┐
│                    MVP INFRASTRUCTURE                                  │
├──────────────────────────────────────────────────────────────────────┤
│                                                                      │
│  ┌──────────────────────────────────────────────────────────────┐   │
│  │                        VPS / Server                            │   │
│  │                                                                │   │
│  │  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌──────────┐     │   │
│  │  │ Nginx    │  │ PHP-FPM  │  │ MySQL    │  │ Supervisor│     │   │
│  │  │ :80/443  │  │ :9000    │  │ :3306    │  │ (queue,  │     │   │
│  │  │          │  │          │  │          │  │  sched)  │     │   │
│  │  └──────────┘  └──────────┘  └──────────┘  └──────────┘     │   │
│  │                                                                │   │
│  └──────────────────────────────────────────────────────────────┘   │
│                                                                      │
│  Simple, cost-effective, easy to deploy.                             │
│  Redis ditambahkan saat scaling.                                     │
│                                                                      │
└──────────────────────────────────────────────────────────────────────┘
```

---

**Dokumen ini adalah living document.** Akan diperbarui seiring pertumbuhan platform.
