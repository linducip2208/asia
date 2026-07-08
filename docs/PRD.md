# Product Requirements Document (PRD)
## ERPAsia — SaaS White Label Retail Commerce Platform

---

### Versi Dokumen

| Versi | Tanggal    | Penulis | Deskripsi Perubahan           |
|-------|------------|---------|-------------------------------|
| 2.0   | 2026-07-09 | Tim Dev | Upgrade ke SaaS Multi-Tenant Enterprise |
| 1.0   | 2026-05-31 | Tim Dev | Draft awal PRD pos-retail     |

---

## Daftar Isi

1. [Visi & Misi Produk](#1-visi--misi-produk)
2. [Target Vertikal Industri](#2-target-vertikal-industri)
3. [Target User & Persona](#3-target-user--persona)
4. [Fitur Lengkap per Modul](#4-fitur-lengkap-per-modul)
5. [Tech Stack](#5-tech-stack)
6. [Non-Functional Requirements](#6-non-functional-requirements)
7. [Arsitektur Multi-Tenant](#7-arsitektur-multi-tenant)
8. [Database Strategy](#8-database-strategy)
9. [UI/UX Guidelines](#9-uiux-guidelines)
10. [Timeline & Milestone](#10-timeline--milestone)
11. [Definisi Sukses](#11-definisi-sukses)
12. [Glosarium](#12-glosarium)

---

## 1. Visi & Misi Produk

### Visi
Menjadi **platform commerce ritel white-label #1 di Asia Tenggara** yang memungkinkan siapapun menjalankan bisnis ritel modern tanpa membangun software dari nol.

### Misi
1. Menyediakan **satu codebase** untuk semua jenis bisnis ritel
2. Memungkinkan **white-label penuh** — reseller bisa rebrand dan jual sebagai produk sendiri
3. **SaaS-native** — tenant bisa daftar online, pilih paket, langsung pakai
4. **Open integration** — tidak lock-in ke provider payment/SMS/AI tertentu
5. **Enterprise-grade** — arsitektur siap melayani jutaan transaksi per hari

### Jenis Bisnis yang Didukung (SATU CODEBASE)

| Vertikal | Contoh Bisnis |
|---|---|
| **Retail Store** | Toko kelontong, sembako, aksesoris |
| **Grocery / Supermarket** | Supermarket, hypermarket |
| **Minimarket** | Convenience store, franchise minimarket |
| **Wholesale / Distributor** | Grosir, distributor B2B |
| **Restaurant** | Restoran full-service, fine dining |
| **Cafe** | Coffee shop, bakery, dessert cafe |
| **Pharmacy / Apotek** | Apotek, toko obat |
| **Workshop / Bengkel** | Bengkel motor, mobil, service center |
| **Laundry** | Laundry kiloan, satuan, dry clean |
| **Fashion / Butik** | Pakaian, sepatu, tas, aksesori |
| **Electronics** | HP, laptop, gadget, aksesori |
| **Furniture** | Mebel, furniture custom |

---

## 2. Target Vertikal Industri

### Konfigurasi per Vertikal (Feature Toggle)

| Fitur | Retail | F&B | Apotek | Bengkel | Laundry | Grosir |
|---|---|---|---|---|---|---|
| Barcode Scanner | ✅ | ✅ | ✅ | ❌ | ❌ | ✅ |
| Table Management | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ |
| Kitchen Display | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ |
| Batch / Expiry | ❌ | ✅ | ✅ | ❌ | ❌ | ✅ |
| Resep Dokter | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ |
| Service Advisors | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ |
| Spare Parts | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ |
| Laundry Status | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ |
| Production / BOM | ❌ | ✅ | ✅ | ❌ | ❌ | ❌ |
| Multi Price Tier | ✅ | ❌ | ❌ | ❌ | ❌ | ✅ |
| Serial Number | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ |

---

## 3. Target User & Persona

### Super Admin (Platform Owner)
- **Kebutuhan:** Kelola semua tenant, subscription, billing, monitoring, license
- **Skill:** Tinggi (technical)
- **Frekuensi:** Harian
- **Panel:** Super Admin Panel (`/super`)

### Owner / Pemilik Bisnis (Tenant Admin)
- **Kebutuhan:** Dashboard bisnis, laporan, kelola user, atur strategi harga
- **Skill:** Menengah
- **Frekuensi:** Harian
- **Panel:** Tenant Admin Panel (`/admin`)

### Manager Operasional
- **Kebutuhan:** Kelola stok, supplier, approval, rekap kasir, closing harian
- **Skill:** Menengah-tinggi
- **Frekuensi:** Sepanjang jam kerja
- **Panel:** Tenant Admin Panel

### Kasir
- **Kebutuhan:** Transaksi cepat, scan barcode, terima bayar, cetak struk
- **Skill:** Dasar-menengah
- **Frekuensi:** Sepanjang shift
- **Panel:** POS Interface (`/pos`) atau Flutter App

### Admin Gudang
- **Kebutuhan:** Terima barang, stok opname, transfer stok
- **Skill:** Dasar-menengah
- **Frekuensi:** Harian
- **Panel:** Tenant Admin Panel

### Customer / Pelanggan (End User)
- **Kebutuhan:** Cek poin, riwayat belanja, upload bukti bayar
- **Skill:** Dasar
- **Frekuensi:** Sesekali
- **Panel:** Customer Portal (`/portal`)

---

## 4. Fitur Lengkap per Modul

### 4.1 DASHBOARD

#### Super Admin Dashboard
| Widget | Deskripsi |
|---|---|
| Total Tenants | Jumlah tenant aktif/total |
| MRR (Monthly Recurring Revenue) | Pendapatan berulang bulan ini |
| New Tenants | Tenant baru 30 hari terakhir |
| Churn Rate | Tenant berhenti 30 hari terakhir |
| Resource Usage | Storage, API calls, users per tenant |
| System Health | CPU, memory, disk, queue status |
| Recent Tickets | Support ticket terbaru |
| Revenue Chart | Grafik MRR 12 bulan |

#### Tenant Dashboard (per role)
| Widget | Visible To |
|---|---|
| Stats Overview (Pendapatan, Transaksi, Customer, Stok Rendah) | Semua role |
| Revenue Chart (30 hari) | Owner, Manager |
| Top Products Chart | Owner, Manager |
| Payment Method Donut | Owner, Manager |
| Recent Orders Table | Semua (scoped per outlet) |
| Low Stock Alert Table | Semua |
| Expiring Products Alert | Manager, Gudang |
| Kasir Today Transactions | Kasir |
| Pending Approvals | Owner, Manager |
| Warehouse Purchase Orders | Gudang |
| Cash Drawer Status | Kasir, Manager |

---

### 4.2 PENJUALAN (Sales)

| Sub-Menu | Status | Deskripsi |
|---|---|---|
| **POS Kasir** | ✅ Ada | Interface kasir cepat (Blade + Alpine.js) |
| **Daftar Penjualan** | ✅ Ada | List, filter, detail order, receipt |
| **Retur Penjualan** | ✅ Ada | Return barang, refund calculation |
| **Quotation** | ❌ Baru | Quote → Order conversion workflow |
| **Draft Penjualan** | ❌ Baru | Simpan transaksi sebagai draft, resume nanti |
| **Hold / Suspend Bill** | ✅ Ada | Tahan transaksi yang belum selesai |
| **Delivery Order** | ❌ Baru | Generate DO, tracking pengiriman |
| **Riwayat Transaksi** | ✅ Ada | Riwayat per shift, per kasir |

#### Quotation Workflow
```
Draft Quote → Kirim ke Customer → 
Follow-up / Negosiasi → Accepted → 
Convert ke Order → Order Diproses
```

#### Delivery Order Workflow
```
Order Dibayar → Generate DO → 
Assign Kurir → Pick & Pack → 
Dalam Pengiriman → Terkirim / Diterima
```

---

### 4.3 PEMBELIAN (Purchases)

| Sub-Menu | Status | Deskripsi |
|---|---|---|
| **Purchase Order (PO)** | ✅ Ada | CRUD PO, approval workflow |
| **Pembelian / Penerimaan** | ❌ Baru | Terima barang dari PO, update stok |
| **Retur Pembelian** | ❌ Baru | Return barang ke supplier |
| **Supplier Invoice** | ✅ Ada | Kelola invoice dari supplier |
| **Riwayat Pembelian** | ❌ Baru | Audit trail semua pembelian |

#### PO Workflow
```
Low Stock Alert → Buat PO (auto-suggest qty) → 
Draft → Kirim ke Supplier → 
Approval (jika di atas threshold) → 
Konfirmasi Supplier → 
Terima Barang (sebagian/lengkap) → 
Update Stok & Hutang → Selesai
```

---

### 4.4 INVENTORY

| Sub-Menu | Status | Deskripsi |
|---|---|---|
| **Produk** | ✅ Ada | CRUD produk + varian + multi satuan |
| **Kategori** | ✅ Ada | Hierarchical category tree |
| **Brand** | ✅ Ada | Merek produk |
| **Unit / Satuan** | ✅ Ada | Satuan + konversi (pcs, box, kg, ltr) |
| **Gudang** | ❌ Baru | Multi-warehouse management |
| **Outlet** | ✅ Ada | Multi-outlet/ cabang |
| **Stok Masuk** | ❌ Baru | Inbound stock receipt log |
| **Stok Keluar** | ❌ Baru | Outbound stock dispatch log |
| **Transfer Stok** | ✅ Ada | Transfer antar gudang/outlet |
| **Stok Opname** | ✅ Ada | Periodik & ad-hoc stock count |
| **Penyesuaian Stok** | ❌ Baru | Manual adjustment dengan reason |
| **Batch Number** | ❌ Baru | Lot/batch tracking per stok masuk |
| **Expired Product** | ❌ Baru | Expiry date tracking + FEFO |
| **Barcode / Label** | ⚠️ Partial | Generate & print barcode label |

#### Gudang Management
- Multi gudang per outlet
- Kapasitas per gudang
- Rack/bin location
- Default gudang per produk

#### Batch & Expiry
- Setiap stok masuk punya batch number
- Expiry date per batch
- FEFO (First Expired First Out) saat picking
- Alert: expiring in 30/14/7/1 days

---

### 4.5 PRODUKSI / MANUFAKTUR

| Sub-Menu | Status | Deskripsi |
|---|---|---|
| **Raw Material** | ✅ Ada | Bahan baku dengan stok |
| **Recipe / BOM** | ✅ Ada | Bill of Materials (resep/ formula) |
| **Produksi** | ❌ Baru | Production order/work order |
| **Waste / Loss** | ❌ Baru | Catat material terbuang |
| **Stock Bahan** | ❌ Baru | Dashboard raw material stock |

#### Production Workflow
```
Production Order → Reserve Raw Materials → 
Production In Progress → 
Output: Finished Goods + Waste → 
Update Raw Material Stock → 
Update Finished Goods Stock
```

---

### 4.6 CRM / CUSTOMER

| Sub-Menu | Status | Deskripsi |
|---|---|---|
| **Customer** | ✅ Ada | Database pelanggan + riwayat belanja |
| **Customer Group** | ✅ Ada | Segmentasi (new, active, VIP, dormant) |
| **Membership / Tier** | ✅ Ada | Silver/Gold/Platinum tier system |
| **Loyalty Point** | ✅ Ada | Poin reward + redeem |
| **Gift Voucher** | ❌ Baru | E-voucher generation & redemption |
| **Piutang Customer / AR** | ❌ Baru | Accounts receivable aging |

#### Gift Voucher
- Generate batch voucher (kode unik)
- Nilai nominal atau persentase
- Expiry date per voucher
- Term & condition per voucher
- Track redemption history

#### Customer AR
- Piutang dari penjualan kredit
- Jatuh tempo per invoice
- Payment collection
- AR Aging Report: 0-30, 31-60, 61-90, >90 hari

---

### 4.7 SUPPLIER

| Sub-Menu | Status | Deskripsi |
|---|---|---|
| **Supplier** | ✅ Ada | Database supplier + kontak |
| **Hutang Supplier / AP** | ❌ Baru | Accounts payable aging |
| **Supplier Performance** | ❌ Baru | Rating, on-time delivery, quality score |

#### Supplier Performance Metrics
- On-time delivery rate (%)
- Order accuracy (%)
- Quality score (1-5)
- Average lead time (hari)
- Return rate (%)

---

### 4.8 OUTLET / CABANG

| Sub-Menu | Status | Deskripsi |
|---|---|---|
| **Daftar Outlet** | ✅ Ada | Multi-outlet management |
| **Gudang Outlet** | ❌ Baru | Gudang per outlet |
| **Transfer Antar Outlet** | ❌ Baru | Inter-outlet stock transfer |
| **Sinkronisasi** | ❌ Baru | Data sync status antar outlet |

---

### 4.9 KEUANGAN (Finance)

| Sub-Menu | Status | Deskripsi |
|---|---|---|
| **Chart of Accounts** | ❌ Baru | COA hierarchy (assets, liabilities, equity, revenue, expenses) |
| **Kas** | ❌ Baru | Cash account management |
| **Bank** | ❌ Baru | Bank account management |
| **Jurnal Umum** | ❌ Baru | Double-entry journal entries |
| **Pemasukan** | ❌ Baru | Income entries (non-sales) |
| **Pengeluaran** | ❌ Baru | Expense entries + kategori |
| **Transfer Kas** | ❌ Baru | Cash transfer antar akun |
| **Metode Pembayaran** | ✅ Ada | Payment method CRUD |
| **Pajak** | ❌ Baru | Tax configuration (PPN, PPh) + reporting |
| **Rekonsiliasi Bank** | ❌ Baru | Bank reconciliation |

#### COA Structure
```
1. ASET
  1.1 Aset Lancar (Kas, Bank, Piutang, Persediaan)
  1.2 Aset Tetap (Peralatan, Kendaraan, Bangunan)
2. KEWAJIBAN
  2.1 Hutang Jangka Pendek (AP, Pajak)
  2.2 Hutang Jangka Panjang
3. EKUITAS (Modal, Laba Ditahan)
4. PENDAPATAN (Penjualan, Pendapatan Lain)
5. BEBAN (HPP, Gaji, Sewa, Listrik, Marketing)
```

#### Double-Entry Rule
- Setiap transaksi minimal 2 jurnal (debit + kredit)
- Total debit = total kredit
- Auto-generate dari modul: sales → penjualan + kas/piutang
- Auto-generate dari modul: purchase → inventory + AP
- Manual journal entry untuk adjustment

---

### 4.10 PROMO / MARKETING

| Sub-Menu | Status | Deskripsi |
|---|---|---|
| **Discount** | ✅ Ada | Discount template (percent/fixed) |
| **Voucher** | ❌ Baru | Digital voucher dengan kode unik |
| **Buy X Get Y** | ❌ Baru | Bundle promo: beli A gratis B |
| **Bundle / Paket** | ❌ Baru | Product bundling (paket hemat) |
| **Happy Hour** | ❌ Baru | Time-based discount (jam tertentu) |
| **Promo Member** | ❌ Baru | Membership-specific promo rules |

#### Promo Engine Rules
- Stacking rules: boleh digabung/tidak dengan promo lain
- Priority order (diskon mana yang dihitung dulu)
- Min/max purchase amount
- Applicable products/categories/brands
- Valid date range
- Usage limit (per customer / total)

---

### 4.11 LAPORAN (Reports)

| Sub-Menu | Status | Deskripsi |
|---|---|---|
| **Dashboard Analytics** | ❌ Baru | Executive dashboard dengan drill-down |
| **Laporan Penjualan** | ✅ Ada | Sales summary + detail |
| **Laporan Pembelian** | ❌ Baru | Purchase summary + detail |
| **Laporan Profit** | ❌ Baru | Gross profit per produk/kategori |
| **Laba Rugi (P&L)** | ❌ Baru | Full profit & loss statement |
| **Laporan Stok** | ✅ Ada | Stock position + movement |
| **Stok Opname Report** | ❌ Baru | Opname history + selisih |
| **Produk Terlaris** | ❌ Baru | Best seller ranking |
| **Kategori Terlaris** | ❌ Baru | Best category performance |
| **Laporan Customer** | ❌ Baru | Customer analytics + segmentasi |
| **Laporan Supplier** | ❌ Baru | Supplier purchase analytics |
| **Laporan Kasir** | ❌ Baru | Cashier performance + shift |
| **Laporan Outlet** | ❌ Baru | Per-outlet performance comparison |
| **Laporan Pajak** | ❌ Baru | Tax report (PPN masukan/keluaran) |
| **Laporan Discount** | ❌ Baru | Discount usage analytics |
| **Laporan Return** | ❌ Baru | Return/refund analytics |
| **Shift Kasir Report** | ❌ Baru | Per-shift cash summary |
| **Cash Flow** | ❌ Baru | Arus kas masuk/keluar |
| **Rekap Harian** | ❌ Baru | Daily business recap |
| **Laporan Keuangan** | ✅ Ada | Financial summary |

#### Setiap Laporan Wajib Punya
- Date range filter (dari → sampai)
- Group by: harian/mingguan/bulanan/tahunan
- Outlet filter (multi-select)
- Chart interaktif (Chart.js)
- Summary cards di atas
- Detail table di bawah
- Export: PDF + Excel (CSV)
- Print-friendly layout

---

### 4.12 PEGAWAI / HR

| Sub-Menu | Status | Deskripsi |
|---|---|---|
| **Pegawai** | ✅ Ada | Employee database |
| **Kasir** | ⚠️ Partial | Cashier management (perlu diperdalam) |
| **Shift** | ✅ Ada | Shift scheduling |
| **Absensi** | ✅ Ada | Attendance tracking |
| **Komisi** | ❌ Baru | Commission calculation per sales |
| **Target Penjualan** | ❌ Baru | Sales target setting & monitoring |

#### Komisi
- Rule-based: % dari omset, % dari profit, fixed per item
- Tiered commission (semakin tinggi omset, semakin besar %)
- Per produk / kategori / brand
- Bonus target tercapai
- Komisi tim vs individu

#### Target Penjualan
- Set target per kasir/sales per bulan
- Target per outlet
- Progress tracking real-time
- Leaderboard motivasi

---

### 4.13 NOTIFIKASI

| Sub-Menu | Status | Deskripsi |
|---|---|---|
| **Low Stock Alert** | ⚠️ Widget | Perlu full management UI |
| **Out Of Stock Alert** | ❌ Baru | Stok habis notification |
| **Expired Product Alert** | ❌ Baru | Expiry notification |
| **Approval Notification** | ⚠️ Widget | Pending approval alerts |
| **Purchase Reminder** | ❌ Baru | Reorder point notification |
| **System Notification** | ❌ Baru | Central notification management |

#### Notification Channels
- In-app (database notification via Filament)
- WhatsApp (via provider adapter)
- Email (via provider adapter)
- SMS (via provider adapter)
- Telegram (via provider adapter)

---

### 4.14 INTEGRASI

| Sub-Menu | Status | Deskripsi |
|---|---|---|
| **Provider Management** | ✅ Ada | Generic provider CRUD |
| **WhatsApp Gateway** | ❌ Baru | WA Business API / Fonnte / Wablas |
| **Email SMTP** | ❌ Baru | Custom SMTP per tenant |
| **QRIS** | ❌ Baru | QRIS static & dynamic |
| **Midtrans** | ❌ Baru | Payment gateway |
| **Xendit** | ❌ Baru | Payment gateway |
| **Printer** | ❌ Baru | ESC/POS printer config |
| **Barcode Scanner** | ❌ Baru | Scanner device config |
| **Marketplace** | ❌ Baru | Tokopedia, Shopee, TikTok Shop connector |
| **E-commerce** | ❌ Baru | WooCommerce, Shopify connector |
| **API Management** | ❌ Baru | API key generation & docs |
| **Webhook** | ❌ Baru | Outbound webhook config |

---

### 4.15 PENGATURAN (Tenant Settings)

| Sub-Menu | Status | Deskripsi |
|---|---|---|
| **Profil Perusahaan** | ❌ Baru | Nama, logo, alamat, NPWP, telepon |
| **Outlet / Cabang** | ✅ Ada | Kelola outlet |
| **User Management** | ✅ Ada | Kelola user + role |
| **Role & Permission** | ✅ Ada | RBAC matrix |
| **Nomor Invoice** | ❌ Baru | Custom invoice number format |
| **Backup & Restore** | ❌ Baru | Database backup management |
| **Bahasa** | ❌ Baru | Multi-language (ID, EN) |
| **Zona Waktu** | ❌ Baru | Timezone configuration |
| **Audit Log** | ✅ Ada | Activity audit trail |
| **Activity Log** | ❌ Baru | User activity log |
| **API Key** | ❌ Baru | API key generation untuk integrasi |
| **Email SMTP** | ❌ Baru | SMTP configuration per tenant |
| **WhatsApp Gateway** | ❌ Baru | WA gateway config per tenant |
| **Integrasi** | ❌ Baru | Integration settings |
| **System Configuration** | ✅ Ada | System-wide config (key-value) |

---

### 4.16 SUPER ADMIN PANEL

| Menu | Status | Deskripsi |
|---|---|---|
| **Dashboard** | ❌ Baru | Platform metrics, MRR, tenant health |
| **Tenant Management** | ❌ Baru | List tenant, create, suspend, delete |
| **Subscription Plans** | ❌ Baru | Plan CRUD + feature matrix |
| **Subscription** | ❌ Baru | Active subscriptions per tenant |
| **Billing & Invoices** | ❌ Baru | Generate invoice, payment tracking |
| **Payments** | ❌ Baru | Payment history per tenant |
| **Coupons** | ❌ Baru | Discount coupon untuk subscription |
| **White Label** | ❌ Baru | Custom domain, logo, theme per tenant |
| **Feature Toggle** | ❌ Baru | Enable/disable fitur per tenant/plan |
| **Announcements** | ❌ Baru | Broadcast message ke tenant |
| **Support Tickets** | ❌ Baru | Helpdesk ticket management |
| **System Monitoring** | ❌ Baru | Server health, queue status, error rate |
| **License** | ⚠️ Partial | License pairing (whitelabel v3) |
| **AI Usage** | ❌ Baru | Track AI credit consumption |
| **Storage Usage** | ❌ Baru | Track storage per tenant |
| **API Usage** | ❌ Baru | Rate limit & usage analytics |
| **Audit Log** | ❌ Baru | Global audit trail |
| **System Logs** | ❌ Baru | Laravel log viewer |

---

### 4.17 MODUL TAMBAHAN KHUSUS PER VERTIKAL

#### Restaurant / Cafe
| Fitur | Deskripsi |
|---|---|
| Table Management | Denah meja, status (available/occupied/reserved) |
| Kitchen Display | Tampilan dapur untuk order masuk |
| Menu Management | Kategori menu + foto + deskripsi |
| Modifiers / Topping | Tambahan item (extra cheese, less sugar) |
| Split Bill | Pisah tagihan per orang/meja |

#### Apotek
| Fitur | Deskripsi |
|---|---|
| Resep Dokter | Input resep, print etiket obat |
| Obat Generik vs Paten | Flagging + pencarian |
| Batch & Expiry | Wajib untuk obat |
| BPJS / Asuransi | Integrasi klaim |

#### Bengkel
| Fitur | Deskripsi |
|---|---|
| Service Advisor | Input kendaraan, keluhan, estimasi |
| Spare Parts Management | Parts catalog + stok |
| Work Order | Proses perbaikan step-by-step |
| Job Tracking | Status pengerjaan real-time |
| Mekanik Assignment | Tugas ke mekanik |

#### Laundry
| Fitur | Deskripsi |
|---|---|
| Order Tracking | Status cucian (diterima→dicuci→setrika→siap) |
| Satuan vs Kiloan | Harga per item vs per kg |
| Express Service | Layanan kilat (hari sama) |
| Delivery | Pickup & delivery management |

---

## 5. Tech Stack

### Backend
| Komponen | Teknologi | Keterangan |
|---|---|---|
| Framework | Laravel 13 | PHP 8.3+ |
| Admin Panel | Filament 5.6 | Full-stack admin |
| Templating | Blade + Tailwind CSS 4 | Custom responsive theme |
| Reactive | Livewire | Komponen dinamis |
| Database | MySQL 8.4 | Primary database |
| Session | file / database | Session management |
| Queue | Database (default) | Async processing |
| API | Laravel Sanctum | Token-based auth |
| PDF | Barryvdh/DomPDF | Export laporan |
| Excel | pxlrbt/filament-excel | Export Excel |

### Frontend
| Komponen | Teknologi |
|---|---|
| CSS Framework | Tailwind CSS 4 |
| JS Framework | Alpine.js |
| Charts | Chart.js |
| Icons | Heroicons (Blade) + Font Awesome |
| Font | Inter + JetBrains Mono (Bunny CDN) |

---

## 6. Non-Functional Requirements

### 6.1 Multi-Tenancy
- **Isolasi Data:** Semua query di-scope oleh `tenant_id`
- **Isolasi File:** Storage per tenant di sub-folder terpisah
- **Tenant Identification:** Middleware membaca domain/subdomain untuk identifikasi tenant
- **Onboarding:** Form registrasi → pilih paket → langsung dapat dashboard

### 6.2 Performance
- Waktu respons API: < 200ms (read), < 500ms (write)
- Loading halaman admin: < 2 detik (first paint)
- Database query: semua pakai index optimal
- Pagination: default 15 items per halaman
- Eager loading: hindari N+1 di semua list view

### 6.3 Security
- Password Bcrypt hashed (Laravel default)
- API key & secret encrypted at rest
- Rate limiting: 60 req/menit per endpoint
- SQL injection prevention: parameterized query via Eloquent
- XSS prevention: Blade auto-escape
- CSRF protection: Laravel default
- Audit log: semua aksi CRUD tercatat
- Tenant data isolation: tidak bisa akses data tenant lain

### 6.4 Responsive Design
- Desktop: 1440px+
- Tablet: 768px–1023px
- Mobile: 414px–767px
- Touch targets: min 38×38px (WCAG 2.5.5)
- Kontras warna: min 4.5:1 (WCAG 1.4.3)
- Reduced motion support

### 6.5 Backup & Recovery
- Auto backup database harian (scheduler: 02:00 WIB)
- Retensi: 7 daily + 4 weekly + 3 monthly
- Restore from backup (admin UI)

### 6.6 Audit Trail
- Semua aksi CRUD di-record
- IP address + user agent
- Old values + new values
- Immutable (tidak bisa dihapus/diubah)
- Retensi 2 tahun

### 6.7 Error Handling
- Graceful error pages (403, 404, 500)
- Sentry/Flare integration (opsional)
- Queue failed jobs table
- Retry mechanism 3× + exponential backoff

---

## 7. Arsitektur Multi-Tenant

### Database Strategy: Shared Database + Shared Schema

```
┌─────────────────────────────────────────────────────────────┐
│                    SINGLE DATABASE                           │
│                     (dataerpasia)                             │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  Semua tabel punya kolom `tenant_id`                        │
│  Middleware auto-scope: WHERE tenant_id = current_tenant()  │
│                                                             │
│  ┌───────────────────────────────────────────────────────┐  │
│  │  GLOBAL TABLES (tenant_id = null)                     │  │
│  │  • plans          • coupons          • announcements  │  │
│  └───────────────────────────────────────────────────────┘  │
│                                                             │
│  ┌───────────────────────────────────────────────────────┐  │
│  │  TENANT TABLES (tenant_id = FK)                       │  │
│  │  • outlets        • products         • orders         │  │
│  │  • customers      • suppliers        • categories     │  │
│  │  • payments       • stock_*          • users          │  │
│  │  • settings       • ...                              │  │
│  └───────────────────────────────────────────────────────┘  │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

### Tenant Resolution Flow
```
Request Masuk → Middleware → 
  Subdomain? (tenantA.erpasia.test) → cari tenant by slug
  Header? (X-Tenant-ID) → cari tenant by ID
  Session? → tenant_id di session
→ Set Current Tenant di Service Container
→ Semua query auto-scope WHERE tenant_id = {current}
```

### Fitur White Label per Tenant
- Custom domain (CNAME: toko-anda.com → tenant-123)
- Custom logo & favicon
- Custom nama aplikasi
- Custom warna tema (primary color)
- Custom SMTP
- Custom WhatsApp Gateway
- Custom payment gateway
- Custom invoice header & footer

### Subscription Model
| Paket | Harga/Bulan | Outlet | User | Produk | Transaksi/Hari |
|---|---|---|---|---|---|
| **Free** | Rp 0 | 1 | 2 | 100 | 50 |
| **Starter** | Rp 149K | 1 | 5 | 1.000 | 200 |
| **Professional** | Rp 399K | 3 | 15 | 10.000 | 1.000 |
| **Business** | Rp 999K | 10 | 50 | 50.000 | 5.000 |
| **Enterprise** | Rp 2.499K | Unlimited | Unlimited | Unlimited | Unlimited |
| **Lifetime** | Rp 14.999K (sekali) | Unlimited | Unlimited | Unlimited | Unlimited |

---

## 8. Database Strategy

### Naming Convention
- Tabel: `snake_case` plural (contoh: `products`, `order_items`)
- Kolom FK: `{table_singular}_id` (contoh: `product_id`, `category_id`)
- Pivot: `{table_a}_{table_b}` alphabetical (contoh: `outlet_user`)
- Index: `idx_{table}_{column}` (contoh: `idx_products_sku`)
- Unique: `uk_{table}_{column}` (contoh: `uk_products_barcode`)

### Migration Strategy
- Setiap modul punya file migrasi sendiri
- Urutan berdasarkan dependensi FK
- Gunakan `$table->foreignId()->constrained()->cascadeOnDelete()` untuk pivot
- Gunakan `$table->foreignId()->constrained()->restrictOnDelete()` untuk transaksional
- Semua migrasi bisa di-rollback

### Soft Delete
- Tabel master data: soft delete (categories, products, customers, suppliers)
- Tabel transaksi: TIDAK soft delete (pakai void/cancel status)
- Tabel pivot: hard delete
- Tabel system: hard delete (notifications bertahan 30 hari)

### Audit Strategy
- Tabel `audit_logs` terpisah
- Record: user, action, model, model_id, old_values (JSON), new_values (JSON), ip, user_agent
- Tidak bisa dihapus/diubah
- Retensi: 2 tahun, lalu arsip ke file

### Performance Index
- Semua kolom FK wajib index
- Kolom yang sering di-search: fulltext index (nama produk, customer)
- Kolom date filter: composite index (outlet_id + created_at)
- Kolom status filter: index (order_status, payment_status)

---

## 9. UI/UX Guidelines

### Design System
- **Inspirasi:** Stripe, Linear, Shopify, SAP Fiori
- **Palet:** Blue primary (Color::Blue) dengan gray neutral
- **Typography:** Inter (UI) + JetBrains Mono (code/numbers)
- **Radius:** 14px cards, 8px inputs, 6px badges
- **Shadow:** Soft shadow (0 1px 3px rgba(0,0,0,0.08))
- **Spacing:** 8px base grid system

### Navigation Rules
1. 14 navigation groups dengan emoji prefix
2. Max 12 item per group (split jika lebih)
3. Min 3 item per group (gabung jika kurang)
4. Unique Heroicon per resource
5. All labels Bahasa Indonesia
6. Group utama collapsed: false, sisanya collapsed: true

### Empty States
- Setiap empty state punya: illustration icon + judul + deskripsi + CTA button
- Contoh: "Belum ada produk" → "Tambahkan produk pertama Anda" → [Tambah Produk]

### Loading States
- Skeleton loading untuk cards & tables
- Spinner untuk button actions
- Progress bar untuk upload/import

### Permission Visibility
- Menu tidak muncul jika user tidak punya akses
- Tombol aksi disabled + tooltip jika tidak punya izin
- Data di-scope sesuai outlet assignment

---

## 10. Timeline & Milestone

### Fase 1: Foundation — Multi-Tenant Core (Minggu 1-2)
- Multi-tenant architecture (tenant_id scoping)
- Super Admin Panel (tenant CRUD, dashboard)
- Subscription Plans (CRUD + feature matrix)
- Tenant registration flow
- White label basic (custom logo, name, color)

### Fase 2: Penjualan Module (Minggu 3-4)
- Quotation workflow
- Draft penjualan
- Delivery order
- Enhancement POS Kasir

### Fase 3: Pembelian Module (Minggu 5)
- Penerimaan barang
- Retur pembelian
- Riwayat pembelian
- Enhancement PO workflow

### Fase 4: Inventory Module (Minggu 6-7)
- Gudang management
- Batch number
- Expiry tracking
- Stok masuk/keluar log
- Penyesuaian stok

### Fase 5: Produksi Module (Minggu 8)
- Production order
- Waste tracking
- Stock bahan dashboard
- BOM enhancement

### Fase 6: CRM Module (Minggu 9)
- Gift voucher system
- Customer AR (piutang)
- Supplier performance
- Supplier AP (hutang)

### Fase 7: Finance Module (Minggu 10-12)
- Chart of Accounts
- Double-entry journal
- Kas & Bank management
- Pemasukan & Pengeluaran
- Transfer kas
- Pajak configuration
- Rekonsiliasi bank
- Cash flow statement
- Laba rugi statement

### Fase 8: Promo & Marketing (Minggu 13)
- Voucher system
- Buy X Get Y
- Bundle / paket
- Happy hour
- Promo member
- Discount engine enhancement

### Fase 9: Laporan Module (Minggu 14-15)
- Dashboard Analytics
- Semua 19 laporan
- Chart interaktif
- PDF & Excel export

### Fase 10: HR Module (Minggu 16)
- Komisi calculation
- Target penjualan
- Enhancement shift & absensi

### Fase 11: Notifikasi & Integrasi (Minggu 17-18)
- Notification center
- Payment gateway (Midtrans, Xendit, QRIS)
- WhatsApp & Email gateway
- Printer ESC/POS config
- API key management
- Webhook management

### Fase 12: Super Admin Enhancement (Minggu 19)
- Tenant billing & invoice
- Coupons
- Announcements
- Support tickets
- System monitoring
- AI & Storage usage tracking

### Fase 13: Vertikal Khusus (Minggu 20-22)
- Restaurant/Cafe: Table, Kitchen Display, Menu
- Apotek: Resep, BPJS, Batch/Expiry
- Bengkel: Service Advisor, Work Order
- Laundry: Order tracking

### Fase 14: Polish & Launch (Minggu 23-24)
- Testing (feature + unit)
- Performance optimization
- Documentation
- Marketing landing page
- PSEO
- Deployment production

---

## 11. Definisi Sukses

### Kriteria Rilis MVP (Fase 1-7 selesai)
- [x] Multi-tenant berfungsi (tenant A tidak bisa lihat data tenant B)
- [ ] Super admin bisa kelola tenant + subscription
- [ ] Tenant bisa daftar, pilih paket, langsung pakai
- [ ] Core modules: Penjualan, Pembelian, Inventory, CRM, Finance
- [ ] Laporan Sales, Profit & Loss, Cash Flow
- [ ] White label custom domain + logo + nama
- [ ] Test coverage > 70% untuk business logic
- [ ] Semua halaman responsive

### Metrik Sukses (6 bulan post-launch)
- 50+ tenant aktif
- 99.9% data isolation (zero cross-tenant data leak)
- Waktu transaksi < 30 detik
- Akurasi stok 99%+
- Churn rate < 5% per bulan
- NPS > 50

---

## 12. Glosarium

| Istilah | Definisi |
|---|---|
| **Tenant** | Pelanggan SaaS (misal: Toko Berkah, PT XYZ) |
| **Super Admin** | Platform owner yang kelola semua tenant |
| **MRR** | Monthly Recurring Revenue |
| **White Label** | Rebranding aplikasi dengan merek sendiri |
| **COA** | Chart of Accounts — bagan akun keuangan |
| **AP** | Accounts Payable — hutang ke supplier |
| **AR** | Accounts Receivable — piutang dari customer |
| **BOM** | Bill of Materials — resep/formula produksi |
| **FEFO** | First Expired First Out — stok kadaluarsa dulu keluar dulu |
| **FIFO** | First In First Out — stok masuk dulu keluar dulu |
| **HPP** | Harga Pokok Penjualan |
| **RBAC** | Role-Based Access Control |
| **PSEO** | Programmatic SEO |
| **ESC/POS** | Protokol printer thermal standar Epson |
| **QRIS** | Quick Response Code Indonesian Standard |

---

**Dokumen ini adalah living document.** Akan diperbarui seiring feedback user, perubahan requirement, dan iterasi development.
