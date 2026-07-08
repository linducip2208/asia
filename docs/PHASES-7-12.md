# Phases 7-12: Permission Matrix, API, Modules, Roadmap, Testing, Deployment
## ERPAsia — SaaS White Label Retail Commerce Platform

---

## Phase 7: Permission Matrix (RBAC)

### 7.1 Roles

| # | Role | Slug | Scope | Access |
|---|---|---|---|---|
| 1 | Super Admin | `super_admin` | Global | Super Admin Panel (`/super`), all tenants |
| 2 | Owner | `owner` | Tenant | Full tenant access, all modules |
| 3 | Manager | `manager` | Tenant | Operational management, reports |
| 4 | Admin | `admin` | Tenant | Master data, transactions, basic reports |
| 5 | Kasir | `kasir` | Tenant | POS access, view inventory |
| 6 | Gudang | `gudang` | Tenant | Inventory, purchase, stock opname |
| 7 | Keuangan | `keuangan` | Tenant | Finance module, reports |

### 7.2 Permission Groups (13 groups, 65+ permissions)

| Group | Permissions | Assigned To |
|---|---|---|
| `master-data` | view, create, edit, delete | Owner, Manager, Admin, Gudang |
| `transaksi` | view, create, edit, delete | Owner, Manager, Admin, Kasir |
| `pembelian` | view, create, edit, delete | Owner, Manager, Admin, Gudang |
| `inventori` | view, create, edit, delete | Owner, Manager, Admin, Gudang |
| `produksi` | view, create, edit, delete | Owner, Manager |
| `operasional` | view, create, edit, delete | Owner, Manager, Admin, Gudang, Kasir |
| `loyalitas` | view, create, edit, delete | Owner, Manager, Admin |
| `finance` | view, create, edit, delete | Owner, Manager, Keuangan |
| `laporan` | view, export | Owner, Manager, Keuangan |
| `marketing` | view, create, edit, delete | Owner, Manager, Admin |
| `pegawai` | view, create, edit, delete | Owner, Manager |
| `notifikasi` | view, manage | Owner, Manager |
| `integrasi` | view, create, edit, delete | Owner |
| `sistem` | view, create, edit, delete | Owner, Manager (limited) |
| `super` | manage-tenants, manage-subscriptions, manage-whitelabel, super-panel-access | Super Admin only |
| `special` | pos-access, dashboard-access, * | Various |

### 7.3 Outlet Scoping
- Owner with `*` permission sees all outlets
- Other users only see assigned outlets via `outlet_user` pivot
- Data in list views auto-filtered by outlet assignment

---

## Phase 8: API Design

### 8.1 API v1 Endpoints (existing + new)

```
AUTH
  POST   /api/v1/auth/login
  POST   /api/v1/auth/logout
  GET    /api/v1/auth/me

PRODUCTS
  GET    /api/v1/products
  GET    /api/v1/products/{id}
  POST   /api/v1/products/barcode

CATEGORIES
  GET    /api/v1/categories

CUSTOMERS
  GET    /api/v1/customers
  GET    /api/v1/customers/{id}
  POST   /api/v1/customers

ORDERS
  POST   /api/v1/orders
  GET    /api/v1/orders
  GET    /api/v1/orders/{id}
  GET    /api/v1/orders/today

PAYMENTS
  POST   /api/v1/payment/create
  POST   /api/v1/payment/status
  GET    /api/v1/payment/presets

PAYMENT METHODS
  GET    /api/v1/payment-methods

TABLES (Restaurant)
  GET    /api/v1/tables

WEBHOOKS
  POST   /api/v1/webhooks/{providerCode}

TENANT (v2 - future)
  POST   /api/v2/tenant/register
  GET    /api/v2/tenant/plans
```

### 8.2 Authentication
- Sanctum Token (Bearer) untuk API
- Rate limiting: 60 req/min default
- Login: 5 req/min per IP
- Tenant scoping: auto via auth user's tenant_id

---

## Phase 9: Module Design (per domain)

### 9.1 Penjualan Module (Existing + Enhancement)
- **Existing:** OrderResource, HeldCartResource, ReturResource, CashDrawerTransactionResource
- **New:** QuotationResource, DraftOrderResource, DeliveryOrderResource
- **POS Interface:** Blade + Alpine.js at `/pos`

### 9.2 Pembelian Module (Existing + Enhancement)
- **Existing:** PurchaseOrderResource, SupplierPayableResource
- **New:** PurchaseReceiptResource, PurchaseReturnResource, PurchaseHistory page

### 9.3 Inventory Module (Existing + Enhancement)
- **Existing:** Product, Category, Brand, Unit, StockTransfer, StockOpname, StockMovement resources
- **New:** WarehouseResource, StockInResource, StockOutResource, BatchResource, ExpiryResource, StockAdjustmentResource

### 9.4 Produksi Module (New)
- RawMaterialResource (existing, move to new group)
- RecipeItemResource (existing BOM, enhance)
- ProductionOrderResource (new)
- WasteRecordResource (new)
- RawMaterialDashboard widget (new)

### 9.5 Customer/CRM Module (Existing + Enhancement)
- **Existing:** CustomerResource, CustomerGroupResource, MembershipTierResource, LoyaltyPointResource, LoyaltyRewardResource
- **New:** GiftVoucherResource, CustomerARResource, CustomerPortal enhance

### 9.6 Supplier Module (Existing + Enhancement)
- **Existing:** SupplierResource
- **New:** SupplierPayableResource (move), SupplierPerformance page

### 9.7 Finance Module (New)
- ChartOfAccountResource
- JournalEntryResource
- CashAccountResource
- BankAccountResource
- IncomeEntryResource
- ExpenseEntryResource
- CashTransferResource
- TaxConfigurationResource
- BankReconciliation page

### 9.8 Promo Module (Existing + Enhancement)
- **Existing:** DiscountTemplateResource
- **New:** VoucherResource, BuyXGetYResource, BundleResource, HappyHourResource, MemberPromoResource

### 9.9 Laporan Module (Existing + 16 new pages)
- **Existing:** LaporanPenjualan, LaporanKeuangan, LaporanStok
- **New:** DashboardAnalytics, LaporanPembelian, LaporanProfit, LabaRugi, LaporanProdukTerlaris, LaporanKategori, LaporanCustomer, LaporanSupplier, LaporanKasir, LaporanOutlet, LaporanPajak, LaporanDiscount, LaporanReturn, LaporanShiftKasir, CashFlow, RekapHarian

### 9.10 HR Module (Existing + Enhancement)
- **Existing:** UserResource, AttendanceResource, ShiftResource
- **New:** CommissionResource, SalesTargetResource

### 9.11 Notification Module (New)
- NotificationCenter page
- LowStockAlertResource
- ExpiryAlertResource
- ApprovalNotificationResource

### 9.12 Integration Module (Existing + Enhancement)
- **Existing:** ProviderResource
- **New:** PaymentGatewayConfigResource, WhatsAppGatewayResource, EmailSMTPResource, PrinterConfigResource, APIManagementResource, WebhookConfigResource, MarketplaceConnectorResource

### 9.13 Settings Module (Existing + Enhancement)
- **Existing:** RoleResource, PermissionResource, AuditLogResource, SystemSetting
- **New:** CompanyProfileResource, InvoiceNumberFormatResource, BackupRestoreResource, LanguageResource, TimezoneResource, ActivityLogResource, ApiKeyResource

---

## Phase 10: Implementation Roadmap

### Milestone 1: SaaS Core (Current ✓)
- [x] Multi-tenant database architecture
- [x] Tenant model, BelongsToTenant trait
- [x] SubscriptionPlan model + seeder
- [x] Super Admin Panel provider
- [x] Tenant Resource (Super Admin)
- [x] Permission matrix with super_admin + keuangan roles
- [x] FeatureToggleService
- [x] TenantService + SubscriptionService
- [x] Tenant registration route + controller

### Milestone 2: Sales Enhancement (Week 2-3)
- [ ] Quotation workflow
- [ ] Draft order
- [ ] Delivery order
- [ ] POS enhancement

### Milestone 3: Purchase + Inventory Enhancement (Week 4-5)
- [ ] Purchase receipt
- [ ] Purchase return
- [ ] Warehouse management
- [ ] Batch & expiry tracking
- [ ] Stock in/out/adjustment

### Milestone 4: Finance Core (Week 6-8)
- [ ] Chart of Accounts
- [ ] Double-entry journal
- [ ] Cash & bank management
- [ ] Income & expense entries
- [ ] Tax configuration

### Milestone 5: CRM + Marketing (Week 9-10)
- [ ] Gift voucher system
- [ ] Customer AR
- [ ] Supplier AP & performance
- [ ] Promo engine (BOGO, bundle, happy hour)

### Milestone 6: Reports + HR (Week 11-12)
- [ ] 16 new report pages
- [ ] Commission calculation
- [ ] Sales target management

### Milestone 7: Production + Integration (Week 13-14)
- [ ] Production order workflow
- [ ] Payment gateway integration
- [ ] WhatsApp/Email gateway
- [ ] API & Webhook management
- [ ] Printer ESC/POS config

### Milestone 8: Polish + Launch (Week 15-16)
- [ ] Super Admin subscription management
- [ ] Billing & invoices
- [ ] Feature toggle UI
- [ ] Testing (unit + feature)
- [ ] Performance optimization
- [ ] Documentation
- [ ] Production deployment

---

## Phase 11: Testing Strategy

### 11.1 Unit Tests
- `TenantScopeTest` — verify tenant isolation
- `FeatureToggleTest` — verify feature toggles
- `SubscriptionServiceTest` — verify billing calculation
- `BelongsToTenantTraitTest` — verify auto-scoping
- `PricingServiceTest` — verify promo/discount calculation
- `StockServiceTest` — verify stock movement logic
- `CommissionCalculationTest` — verify commission rules

### 11.2 Feature Tests
- `TenantRegistrationTest` — register → login → setup flow
- `SubscriptionFlowTest` — subscribe → pay → access
- `TenantIsolationTest` — tenant A cannot see tenant B data
- `OrderFlowTest` — create order → payment → stock update → journal
- `PurchaseFlowTest` — PO → receive → AP → payment
- `FinanceFlowTest` — journal entry → balance → reconciliation
- `POSCheckoutTest` — scan → cart → pay → receipt

### 11.3 API Tests
- Auth endpoints (login, logout, me)
- Product CRUD via API
- Order creation via API
- Rate limiting verification
- Tenant scoping verification

### 11.4 Target
- 50+ tests
- 100+ assertions
- All passing
- Code coverage: >70% business logic

---

## Phase 12: Deployment Strategy

### 12.1 Environment Requirements
- PHP 8.3+
- MySQL 8.0+
- Composer 2
- Node.js 20+ (for Vite build)
- Nginx 1.24+
- Supervisor

### 12.2 Deployment Steps
```
1. Clone repository
2. cp .env.example .env → configure DB, APP_URL
3. composer install --no-dev --optimize-autoloader
4. npm install && npm run build
5. php artisan key:generate
6. php artisan migrate --force
7. php artisan db:seed --class=SubscriptionPlanSeeder
8. php artisan storage:link
9. Configure Nginx (see deploy/nginx.conf)
10. Configure Supervisor (see deploy/supervisor.conf)
11. php artisan config:cache
12. php artisan route:cache
13. php artisan optimize
```

### 12.3 Supervisor Configuration
```
[program:erpasia-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/storage/logs/queue-worker.log

[program:erpasia-scheduler]
command=php /path/to/artisan schedule:run
autostart=true
autorestart=true
user=www-data
stdout_logfile=/path/to/storage/logs/scheduler.log
```

### 12.4 Nginx Configuration
```
server {
    listen 80;
    server_name erpasia.test *.erpasia.test;
    root /path/to/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 12.5 Post-Deployment Checklist
- [ ] Run migrations
- [ ] Seed subscription plans
- [ ] Verify `/super` panel accessible
- [ ] Verify tenant registration flow
- [ ] Verify `/admin` login with demo accounts
- [ ] Check scheduler running (`php artisan schedule:run`)
- [ ] Check queue worker running
- [ ] Verify sitemap.xml accessible
- [ ] Verify robots.txt
- [ ] Submit sitemap to Google Search Console

---

## Demo Accounts

### Super Admin Panel (`/super`)
| Role | Email | Password |
|---|---|---|
| Super Admin | super@erpasia.test | password |

### Tenant Admin Panel (`/admin`)
| Role | Email | Password |
|---|---|---|
| Owner | owner@erpasia.test | password |
| Manager | manager@erpasia.test | password |
| Admin | admin@erpasia.test | password |
| Kasir | kasir@erpasia.test | password |
| Gudang | gudang@erpasia.test | password |
| Keuangan | keuangan@erpasia.test | password |

---

**Dokumen ini adalah living document.** Akan diperbarui seiring implementasi.
