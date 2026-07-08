# Business Process Mapping
## ERPAsia — SaaS White Label Retail Commerce Platform

---

## Daftar Isi

1. [Tenant Lifecycle](#1-tenant-lifecycle)
2. [Daily Business Cycle](#2-daily-business-cycle)
3. [Sales Process](#3-sales-process)
4. [Purchase Process](#4-purchase-process)
5. [Inventory Process](#5-inventory-process)
6. [Manufacturing Process](#6-manufacturing-process)
7. [Finance Process](#7-finance-process)
8. [CRM & Loyalty Process](#8-crm--loyalty-process)
9. [HR Process](#9-hr-process)
10. [Promo & Marketing Process](#10-promo--marketing-process)
11. [End-of-Day Process](#11-end-of-day-process)
12. [End-of-Month Process](#12-end-of-month-process)
13. [Exception Handling](#13-exception-handling)

---

## 1. Tenant Lifecycle

### 1.1 Tenant Onboarding Flow

```
┌─────────────┐    ┌──────────────┐    ┌──────────────┐    ┌──────────────┐
│  Landing     │    │  Register    │    │  Choose Plan │    │  Payment     │
│  Page        │───▶│  Form        │───▶│  (Free/Paid)  │───▶│  (if Paid)   │
│  /           │    │  /register   │    │  /plans       │    │  /checkout   │
└─────────────┘    └──────────────┘    └──────────────┘    └──────┬───────┘
                                                                   │
                                                                   ▼
┌─────────────┐    ┌──────────────┐    ┌──────────────┐    ┌──────────────┐
│  Using App  │◀───│  Dashboard   │◀───│  Setup       │◀───│  Account     │
│             │    │  Onboarding  │    │  Wizard      │    │  Activated   │
└─────────────┘    └──────────────┘    └──────────────┘    └──────────────┘
```

**Steps Detail:**
1. User visit landing page → click "Coba Gratis" / "Daftar"
2. Isi form: nama bisnis, slug (subdomain), email, password, nomor HP
3. Verify email (optional, configurable)
4. Pilih paket: Free (langsung aktif) atau paid (lanjut payment)
5. Jika paid → Midtrans/Xendit checkout → payment success → aktivas
6. Redirect ke dashboard dengan onboarding wizard:
   - Step 1: Profil perusahaan (nama, logo, alamat, NPWP)
   - Step 2: Tambah outlet pertama (nama, alamat)
   - Step 3: Tambah user (kasir, admin)
   - Step 4: Tambah produk pertama (min 3)
   - Step 5: Siap digunakan!
7. Tenant bisa skip wizard dan setup manual nanti

### 1.2 Tenant Subscription Lifecycle

```
Active → Grace Period (3 hari) → Suspended → Terminated
  │          │                        │            │
  │          └─ Bayar sebelum         │            └─ Data dihapus
  │             batas → Active lagi   │               setelah 30 hari
  │                                   │
  └─ Upgrade/downgrade plan ─────────┘
     (prorated billing)
```

### 1.3 White Label Setup Flow
```
Tenant beli paket Enterprise/Lifetime →
Akses menu White Label di Settings →
  • Upload logo & favicon
  • Set nama aplikasi custom
  • Pilih warna tema (7 preset + custom hex)
  • Input domain custom (CNAME)
  • Konfigurasi SMTP sendiri
  • Konfigurasi WA Gateway sendiri
→ Simpan → Aplikasi fully rebranded
```

---

## 2. Daily Business Cycle

```
┌─────────────────────────────────────────────────────────────────────┐
│                        DAILY BUSINESS CYCLE                          │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│   PAGI (07:00-08:00)                                                │
│   ┌──────────────────────────────────────────────────────────┐     │
│   │ 1. Kasir Login → Buka Shift                               │     │
│   │ 2. Hitung saldo awal kas (cash drawer opening)            │     │
│   │ 3. Cek stok rendah → buat PO jika perlu                   │     │
│   └──────────────────────────────────────────────────────────┘     │
│                              │                                      │
│                              ▼                                      │
│   SIANG (08:00-16:00)                                               │
│   ┌──────────────────────────────────────────────────────────┐     │
│   │ 1. Transaksi berjalan (POS)                               │     │
│   │ 2. Terima kiriman supplier (jika ada)                     │     │
│   │ 3. Retur customer (jika ada)                              │     │
│   │ 4. Transfer stok antar outlet (jika perlu)                │     │
│   │ 5. Cek notifikasi (low stock, expired, approval)          │     │
│   └──────────────────────────────────────────────────────────┘     │
│                              │                                      │
│                              ▼                                      │
│   SORE (16:00-17:00)                                                │
│   ┌──────────────────────────────────────────────────────────┐     │
│   │ 1. Shift ganti → Kasir sore login, buka shift             │     │
│   │ 2. Kasir pagi: closing shift → hitung kas fisik           │     │
│   │ 3. Manager: verifikasi closing kasir                      │     │
│   └──────────────────────────────────────────────────────────┘     │
│                              │                                      │
│                              ▼                                      │
│   MALAM (17:00-22:00)                                               │
│   ┌──────────────────────────────────────────────────────────┐     │
│   │ 1. Transaksi sore-malam berjalan                          │     │
│   │ 2. Closing shift malam → hitung kas fisik                 │     │
│   │ 3. Rekap harian otomatis digenerate                       │     │
│   └──────────────────────────────────────────────────────────┘     │
│                                                                     │
└─────────────────────────────────────────────────────────────────────┘
```

---

## 3. Sales Process

### 3.1 POS Transaction Flow (Walk-in Customer)

```
Customer datang
  │
  ▼
┌──────────────┐
│ Pilih Produk │ ← Scan barcode / search / kategori grid
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Cart /       │ ← Add item, qty, diskon per item, catatan
│ Keranjang    │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Customer     │ ← Optional: cari customer untuk diskon member
│ Selection    │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Checkout     │ ← Subtotal, diskon, pajak, grand total
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Payment      │ ← Pilih metode bayar → input nominal
│              │    Bisa split payment (cash + QRIS)
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Payment      │
│ Success?     │
└──┬───────┬───┘
   │YES    │NO
   ▼       ▼
┌──────┐ ┌──────────┐
│Print │ │Retry /    │
│Struk │ │Void       │
└──┬───┘ └──────────┘
   │
   ▼
┌──────────────┐
│ Stok Berkurang│ ← Auto decrement di background
│ Poin Bertambah│ ← Jika customer member
│ Jurnal Dibuat│ ← Auto create journal entry
│ Notif Low Stok│ ← Jika stok di bawah threshold
└──────────────┘
```

### 3.2 Split Payment Flow
```
Grand Total: Rp 100.000

Payment 1: CASH   Rp 60.000 → Sisa: Rp 40.000
Payment 2: QRIS   Rp 40.000 → Sisa: Rp 0 → LUNAS ✅

Setiap payment = 1 row di payments table
```

### 3.3 Quotation → Order Flow
```
┌─────────────┐     ┌──────────────┐     ┌──────────────┐
│ Create       │     │ Send to      │     │ Customer     │
│ Quotation    │────▶│ Customer     │────▶│ Review       │
│ (Draft)      │     │ (Email/WA)   │     │              │
└─────────────┘     └──────────────┘     └──────┬───────┘
                                                 │
                                   ┌─────────────┼─────────────┐
                                   ▼             ▼             ▼
                            ┌──────────┐  ┌──────────┐  ┌──────────┐
                            │ Accepted │  │ Rejected │  │ Revised  │
                            └────┬─────┘  └──────────┘  └──────────┘
                                 │
                                 ▼
                          ┌────────────┐
                          │ Convert to │
                          │ Order      │
                          └────┬───────┘
                               │
                               ▼
                          Normal Order Flow
```

### 3.4 Delivery Order Flow
```
Order Paid → Generate DO
  │
  ▼
┌──────────────┐
│ Pick & Pack  │ ← Staff siapkan barang
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Assign Kurir │ ← Pilih kurir / ekspedisi
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Status:      │
│ Dalam        │
│ Pengiriman   │
└──────┬───────┘
       │
       ▼
┌──────────────┐     ┌──────────────┐
│ Terkirim ✅  │     │ Gagal Kirim  │
│              │     │ / Return     │
└──────────────┘     └──────────────┘
```

### 3.5 Hold / Suspend Bill Flow
```
Transaksi sedang berjalan
  │
  ▼
Customer: "Saya cari barang lain dulu"
  │
  ▼
┌──────────────┐
│ Hold Bill    │ ← Simpan cart dengan kode hold
└──────┬───────┘
       │
       ▼ (beberapa menit kemudian)
┌──────────────┐
│ Recall Bill  │ ← Pilih dari hold list → lanjut transaksi
└──────┬───────┘
       │
       ▼
Lanjut Checkout Normal
```

### 3.6 Retur Penjualan Flow
```
Customer bawa barang + struk
  │
  ▼
┌──────────────┐
│ Cari Order   │ ← By order number / customer
│ Asli         │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Pilih Item   │ ← Pilih item yang diretur, qty, alasan
│ Retur        │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Approval?    │ ← Jika nilai di atas threshold → perlu Manager
└──┬───────┬───┘
   │YES    │NO
   ▼       ▼
┌──────────────┐
│ Proses Retur │
│ • Stok kembali bertambah
│ • Refund ke customer (cash/transfer)
│ • Jurnal retur dibuat
│ • Notifikasi ke Manager
└──────────────┘
```

---

## 4. Purchase Process

### 4.1 Purchase Order (PO) Full Flow

```
┌────────────────────────────────────────────────────────────────────┐
│                        PURCHASE ORDER FLOW                          │
├────────────────────────────────────────────────────────────────────┤
│                                                                    │
│  TRIGGER:                                                          │
│  • Low stock alert (auto-suggest)                                  │
│  • Manual: Manager buat PO                                         │
│  • Reorder point tercapai                                          │
│       │                                                            │
│       ▼                                                            │
│  ┌────────────┐                                                    │
│  │ Create PO  │ ← Pilih supplier, produk, qty, harga, estimasi    │
│  │ (Draft)    │    kirim, notes                                     │
│  └─────┬──────┘                                                    │
│        │                                                            │
│        ▼                                                            │
│  ┌────────────┐                                                    │
│  │ Submit PO  │ ← Kirim ke supplier (via email/WA)                 │
│  │ (Submitted)│                                                    │
│  └─────┬──────┘                                                    │
│        │                                                            │
│        ▼                                                            │
│  ┌────────────┐                                                    │
│  │ Need       │──── YES ──▶ Pending Approval ──▶ Approved / Reject │
│  │ Approval?  │                                                    │
│  └─────┬──────┘                                                    │
│        │ NO                                                        │
│        ▼                                                            │
│  ┌────────────┐                                                    │
│  │ Supplier   │ ← Supplier konfirmasi / estimasi kirim             │
│  │ Confirmed  │                                                    │
│  └─────┬──────┘                                                    │
│        │                                                            │
│        ▼                                                            │
│  ┌────────────┐                                                    │
│  │ Receive    │ ← Barang datang → input qty diterima               │
│  │ Goods      │    • Input batch number + expiry (jika relevan)    │
│  │ (Partial/  │    • Bisa terima sebagian (partial)                │
│  │  Complete) │                                                    │
│  └─────┬──────┘                                                    │
│        │                                                            │
│        ├── All received? ── YES ──▶ Status: Completed              │
│        │                                                            │
│        └── Partial ──▶ Status: Partially Received                  │
│                        (bisa receive lagi nanti)                    │
│                                                                    │
│  AFTER RECEIVE (auto):                                             │
│  • Stok bertambah (per outlet/gudang)                              │
│  • Stock movement: type=in, reference=PO                           │
│  • Hutang AP bertambah (accounts payable)                          │
│  • Jurnal: Inventory (D) + AP (K)                                  │
│  • Jika ada batch → batch_movements tercatat                       │
│                                                                    │
└────────────────────────────────────────────────────────────────────┘
```

### 4.2 Retur Pembelian Flow
```
┌────────────┐
│ Create     │ ← Pilih PO/supplier, item, qty, alasan retur
│ Return     │    (rusak, expired, tidak sesuai)
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Approval?  │── YES ──▶ Manager approve
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Process    │
│ Return     │
│ • Stok berkurang
│ • Hutang AP berkurang
│ • Stock movement: type=out, reference=return
└────────────┘
```

### 4.3 Supplier Invoice → Payment Flow
```
PO Received → Otomatis buat Supplier Payable (AP)

┌────────────┐
│ Supplier   │ ← Supplier kirim invoice (upload/buat manual)
│ Invoice    │
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Match with │ ← Cocokkan invoice dengan PO/receipt
│ PO/Receipt │
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Payment    │ ← Bayar ke supplier
│            │    • Pilih metode (transfer, cash, cek)
│            │    • Input nominal, tanggal, referensi
│            │    • Reduce AP balance
│            │    • Jurnal: AP (D) + Kas/Bank (K)
└────────────┘
```

---

## 5. Inventory Process

### 5.1 Stock In Flow (Semua jenis stok masuk)

```
┌──────────────────────────────────────────────────────────────┐
│                    STOCK IN SOURCES                           │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  1. PURCHASE RECEIPT                                         │
│     PO → Receive Goods → Stock In (reference: purchase)      │
│                                                              │
│  2. SALES RETURN                                             │
│     Retur Penjualan → Stock In (reference: sales_return)     │
│                                                              │
│  3. STOCK TRANSFER (IN)                                      │
│     Transfer dari outlet lain → Stock In (reference: trf_in) │
│                                                              │
│  4. PRODUCTION OUTPUT                                        │
│     Produksi selesai → Stock In (reference: production)      │
│                                                              │
│  5. MANUAL ADJUSTMENT (IN)                                   │
│     Penyesuaian stok + → Stock In (reference: adjustment)    │
│                                                              │
│  SEMUA STOCK IN → Catat di stock_movements                   │
│                → Update products.current_stock               │
│                → Jika batch → catat di batch_movements       │
│                                                              │
└──────────────────────────────────────────────────────────────┘
```

### 5.2 Stock Out Flow

```
┌──────────────────────────────────────────────────────────────┐
│                    STOCK OUT SOURCES                          │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  1. SALES                                                    │
│     Order completed → Stock Out (reference: order)           │
│                                                              │
│  2. PURCHASE RETURN                                          │
│     Retur Pembelian → Stock Out (reference: purchase_return) │
│                                                              │
│  3. STOCK TRANSFER (OUT)                                     │
│     Transfer ke outlet lain → Stock Out (reference: trf_out) │
│                                                              │
│  4. PRODUCTION CONSUMPTION                                   │
│     Bahan baku dipakai → Stock Out (reference: production)   │
│                                                              │
│  5. WASTE / DAMAGE                                           │
│     Barang rusak/kadaluarsa → Stock Out (reference: waste)   │
│                                                              │
│  6. MANUAL ADJUSTMENT (OUT)                                  │
│     Penyesuaian stok - → Stock Out (reference: adjustment)   │
│                                                              │
└──────────────────────────────────────────────────────────────┘
```

### 5.3 Stock Opname Flow
```
┌────────────┐
│ Create     │ ← Pilih outlet/gudang, produk (bisa filter kategori)
│ Opname     │    Bisa ad-hoc atau terjadwal
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Input Stok │ ← Petugas hitung stok fisik → input actual_stock
│ Fisik      │    per produk (bisa dilakukan bertahap)
└─────┬──────┘
      │
      ▼
┌────────────┐
│ System     │ ← Bandingkan system_stock vs actual_stock
│ Compare    │    Hitung difference
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Review     │ ← Manager review selisih
│ Selisih    │    Investigasi selisih besar (>5% atau >threshold)
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Approve &  │ ← Status: completed
│ Complete   │    • Auto adjustment stok (system = actual)
│             │    • Stock movement: type=adjustment, reference=opname
│             │    • Catat selisih di laporan
└────────────┘
```

### 5.4 Stock Transfer Flow
```
┌────────────┐
│ Create     │ ← Pilih outlet asal, outlet tujuan, produk, qty
│ Transfer   │    Status: draft
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Approval   │ ← Manager approve (opsional, configurable)
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Pick &     │ ← Outlet asal: siapkan barang
│ Pack       │    Status: in_transit
│            │    • Stok outlet asal: berkurang (reserved)
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Receive    │ ← Outlet tujuan: terima barang
│            │    • Input qty diterima (bisa kurang dari dikirim)
│            │    • Status: received
│            │    • Stok outlet tujuan: bertambah
└────────────┘
```

### 5.5 Batch & Expiry Flow
```
┌──────────────────────────────────────────────────────────────┐
│                    BATCH & EXPIRY FLOW                         │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  SAAT PENERIMAAN BARANG:                                     │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ Input: batch_number, production_date, expiry_date     │   │
│  │ System auto-create batch entry                        │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                              │
│  SAAT PENJUALAN:                                             │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ FEFO: system suggest batch yang paling dekat expired  │   │
│  │ Kasir bisa override (highlight warning)               │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                              │
│  NOTIFIKASI EXPIRY:                                          │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ • 30 hari sebelum expired → notifikasi                │   │
│  │ • 14 hari → warning                                   │   │
│  │ • 7 hari → alert orange                               │   │
│  │ • 1 hari → alert red                                  │   │
│  │ • Expired → auto-flag, perlu penyesuaian/waste        │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                              │
└──────────────────────────────────────────────────────────────┘
```

---

## 6. Manufacturing Process

### 6.1 Production Order Flow
```
┌────────────┐
│ Create     │ ← Pilih recipe/BOM, qty output yang diinginkan
│ Production │    System auto-calculate kebutuhan raw material
│ Order      │    Cek ketersediaan raw material
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Reserve    │ ← Reserve raw material (tidak bisa dijual)
│ Materials  │    Status: planned
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Start      │ ← Mulai produksi
│ Production │    Status: in_progress
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Record     │ ← Input output:
│ Output &   │    • Finished goods qty (bisa partial)
│ Waste      │    • Waste/loss qty + reason
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Complete   │ ← Status: completed
│ Production │    • Raw material stock: berkurang (consumed)
│             │    • Finished goods stock: bertambah
│             │    • Waste tercatat
│             │    • Jurnal: FG Inventory (D) + WIP (K)
└────────────┘
```

### 6.2 BOM / Recipe Types
```
┌──────────────────────────────────────────────────────────────┐
│                    BOM TYPES                                  │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  1. STANDARD BOM                                             │
│     1 Output Item = N Raw Materials                          │
│     Contoh: 1 Kue = 200g tepung + 2 telur + 100g gula        │
│                                                              │
│  2. BATCH BOM                                                │
│     1 Batch Output = N Raw Materials untuk banyak unit       │
│     Contoh: 50 Kue = 10kg tepung + 100 telur + 5kg gula      │
│                                                              │
│  3. PACKAGING BOM                                            │
│     N produk kecil → 1 paket besar                           │
│     Contoh: 12 Botol = 1 Karton                              │
│                                                              │
│  4. DISASSEMBLY BOM                                          │
│     1 item besar → N parts/komponen                          │
│     Contoh: 1 PC = parts untuk dijual terpisah               │
│                                                              │
└──────────────────────────────────────────────────────────────┘
```

---

## 7. Finance Process

### 7.1 Chart of Accounts Setup
```
┌──────────────────────────────────────────────────────────────┐
│                    DEFAULT COA                                │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  1-0000 ASET                                                  │
│    1-1000 Aset Lancar                                        │
│      1-1100 Kas Utama                                        │
│      1-1200 Bank BCA                                         │
│      1-1300 Piutang Usaha (AR)                               │
│      1-1400 Persediaan Barang                                │
│      1-1500 Perlengkapan                                     │
│    1-2000 Aset Tetap                                         │
│      1-2100 Peralatan                                        │
│      1-2200 Kendaraan                                        │
│                                                              │
│  2-0000 KEWAJIBAN                                            │
│    2-1000 Kewajiban Jangka Pendek                            │
│      2-1100 Hutang Usaha (AP)                                │
│      2-1200 Hutang Pajak (PPN)                               │
│    2-2000 Kewajiban Jangka Panjang                            │
│                                                              │
│  3-0000 EKUITAS                                              │
│    3-1000 Modal Disetor                                      │
│    3-2000 Laba Ditahan                                       │
│                                                              │
│  4-0000 PENDAPATAN                                           │
│    4-1000 Penjualan                                          │
│    4-2000 Pendapatan Lain-lain                               │
│                                                              │
│  5-0000 BEBAN                                                │
│    5-1000 Harga Pokok Penjualan (HPP)                        │
│    5-2000 Beban Operasional                                  │
│      5-2100 Beban Gaji                                       │
│      5-2200 Beban Sewa                                       │
│      5-2300 Beban Listrik & Air                              │
│      5-2400 Beban Marketing                                  │
│    5-3000 Beban Lain-lain                                    │
│                                                              │
└──────────────────────────────────────────────────────────────┘
```

### 7.2 Auto Journal dari Modul Lain

| Trigger | Debit | Kredit |
|---|---|---|
| Penjualan (Cash) | Kas (1-1100) | Penjualan (4-1000) |
| Penjualan (Kredit) | Piutang AR (1-1300) | Penjualan (4-1000) |
| HPP (Penjualan) | HPP (5-1000) | Persediaan (1-1400) |
| Pembelian (Cash) | Persediaan (1-1400) | Kas (1-1100) |
| Pembelian (Kredit) | Persediaan (1-1400) | Hutang AP (2-1100) |
| Bayar Hutang | Hutang AP (2-1100) | Kas/Bank (1-1100/1-1200) |
| Retur Penjualan | Penjualan (4-1000) | Kas (1-1100) |
| Retur Pembelian | Hutang AP (2-1100) | Persediaan (1-1400) |
| Bayar Gaji | Beban Gaji (5-2100) | Kas/Bank |
| Bayar Sewa | Beban Sewa (5-2200) | Kas/Bank |

### 7.3 Bank Reconciliation Flow
```
┌────────────┐
│ Select     │ ← Pilih akun bank, periode
│ Account    │
└─────┬──────┘
      │
      ▼
┌────────────┐
│ System     │ ← Saldo menurut sistem (dari jurnal)
│ Balance    │
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Input Bank │ ← Input saldo bank statement
│ Statement   │
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Match      │ ← Tick transaksi yang match (auto-match jika referensi sama)
│ Items      │
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Identify   │ ← Unmatched items:
│ Difference │    • Outstanding checks (belum dicairkan)
│             │    • Deposit in transit (belum masuk bank)
│             │    • Bank fees (admin bank)
│             │    • Interest income
│             │    • Errors
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Adjustment │ ← Buat adjustment entries untuk selisih
│ Entries    │
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Complete   │ ← Status: reconciled
│ Recon      │
└────────────┘
```

### 7.4 Cash Flow Process
```
Cash In:
  • Penjualan tunai (POS)
  • Pembayaran piutang (AR Collection)
  • Pendapatan lain-lain
  • Modal disetor

Cash Out:
  • Pembayaran supplier (AP Payment)
  • Beban operasional (gaji, sewa, listrik)
  • Pembelian aset
  • Pajak

Net Cash Flow = Cash In - Cash Out
```

---

## 8. CRM & Loyalty Process

### 8.1 Customer Lifecycle
```
New Customer (Register / Walk-in pertama)
  │
  ▼
┌────────────┐
│ Active     │ ← Transaksi terakhir < 90 hari
└─────┬──────┘
      │ (90 hari tanpa transaksi)
      ▼
┌────────────┐
│ Dormant    │ ← 90-180 hari tanpa transaksi
└─────┬──────┘
      │ (180 hari tanpa transaksi)
      ▼
┌────────────┐
│ Churned    │ ← >180 hari tanpa transaksi
└────────────┘
```

### 8.2 Loyalty Point Flow
```
Customer belanja Rp 100.000
  │
  ▼
Konversi: Rp 1.000 = 1 poin → 100 poin
  │
  ▼
Poin masuk ke loyalty_points table
  │
  ├── Poin bisa ditukar setelah minimal terkumpul X
  │
  └── Poin expired setelah 12 bulan tidak ada transaksi
      │
      ▼
Notifikasi: "Poin Anda 500 akan expired bulan depan!"
```

### 8.3 Membership Tier Upgrade/Downgrade
```
┌──────────────────────────────────────────────────────────────┐
│                    MONTHLY CRON JOB                           │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  Setiap tanggal 1, 00:00                                     │
│                                                              │
│  1. Hitung total_spent 6 bulan terakhir per customer         │
│  2. Bandingkan dengan threshold tier                         │
│                                                              │
│  Silver → Gold: total_spent >= Rp 5.000.000                  │
│  Gold → Platinum: total_spent >= Rp 25.000.000               │
│                                                              │
│  Gold → Silver: total_spent < Rp 2.500.000 (downgrade)       │
│  Platinum → Gold: total_spent < Rp 12.500.000 (downgrade)    │
│                                                              │
│  3. Update customer group                                    │
│  4. Kirim notifikasi ke customer                             │
│                                                              │
└──────────────────────────────────────────────────────────────┘
```

### 8.4 Gift Voucher Flow
```
Admin generate voucher batch
  │
  ▼
┌────────────┐
│ Input:     │ ← Nama, nominal/%, jumlah, expiry, terms
│ Voucher    │
└─────┬──────┘
      │
      ▼
System generate kode unik (misal: VCR-ABCD-EFGH-IJKL)
  │
  ▼
Customer dapat voucher (dikirim WA/email/manual)
  │
  ▼
Customer pakai di POS: input kode voucher
  │
  ▼
System validate:
  • Kode valid?
  • Belum expired?
  • Belum terpakai?
  • Min purchase terpenuhi?
  • Bisa digabung dengan promo lain?
  │
  ▼
✅ Valid → Diskon diterapkan → Voucher status: redeemed
❌ Invalid → Tampilkan pesan error
```

---

## 9. HR Process

### 9.1 Shift Management
```
Pagi (07:00-15:00) ─────▶ Sore (15:00-22:00) ─────▶ Malam (22:00-07:00*)
                                                          │
                                                    *Opsional
```

```
┌────────────┐
│ Kasir      │ ← Login → pilih shift → buka shift
│ Login      │    Input saldo awal kas
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Transaksi  │ ← Semua transaksi tercatat di shift ini
│ Berjalan   │
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Closing    │ ← Hitung kas fisik
│ Shift      │    • Total tunai = saldo awal + cash in - cash out
│             │    • Input fisik → system hitung selisih
│             │    • Cetak laporan closing
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Manager    │ ← Manager verifikasi closing
│ Verifikasi │    • Approve / reject
│             │    • Jika selisih > threshold → investigasi
└────────────┘
```

### 9.2 Komisi Calculation
```
┌──────────────────────────────────────────────────────────────┐
│                    COMMISSION RULES                           │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  Rule Types:                                                 │
│                                                              │
│  1. PERCENT_OF_SALES: 2% dari total penjualan                │
│  2. PERCENT_OF_PROFIT: 5% dari laba (harga jual - harga beli)│
│  3. FIXED_PER_ITEM: Rp 5.000 per item terjual                │
│  4. TIERED: 1% untuk 0-10jt, 2% untuk 10jt-50jt, dst        │
│  5. TARGET_BONUS: Rp 500.000 jika capai target bulanan       │
│                                                              │
│  Calculation (monthly cron, tanggal 1):                      │
│                                                              │
│  1. Ambil semua transaksi kasir bulan lalu                    │
│  2. Hitung komisi per rule                                   │
│  3. Generate komisi report                                   │
│  4. Buat jurnal: Beban Komisi (D) + Hutang Komisi (K)        │
│                                                              │
└──────────────────────────────────────────────────────────────┘
```

---

## 10. Promo & Marketing Process

### 10.1 Promo Engine Priority & Stacking

```
┌──────────────────────────────────────────────────────────────┐
│                    PROMO EVALUATION ORDER                      │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  Saat checkout, system evaluate promo dengan urutan:          │
│                                                              │
│  1. MEMBER DISCOUNT (auto-apply)                             │
│     • Silver: 2%, Gold: 5%, Platinum: 10%                    │
│     • Off total order                                        │
│                                                              │
│  2. PRODUCT-SPECIFIC DISCOUNT                                │
│     • Diskon per item (percent atau fixed)                   │
│     • Off item price                                         │
│                                                              │
│  3. BUNDLE PROMO (Buy X Get Y / Bundle)                      │
│     • Beli A gratis B / beli 3 harga 2                       │
│     • Item-termurah gratis                                   │
│                                                              │
│  4. HAPPY HOUR (time-based)                                  │
│     • Diskon 20% jam 14:00-17:00                             │
│     • Off total order setelah diskon lain                    │
│                                                              │
│  5. VOUCHER                                                  │
│     • Kode unik, nominal atau persentase                     │
│     • Off grand total                                        │
│                                                              │
│  STACKING RULES:                                             │
│  • "Stackable" = bisa digabung dengan promo lain             │
│  • "Exclusive" = tidak bisa digabung, pilih yang terbaik     │
│  • Configurable per promo                                    │
│                                                              │
│  VALIDATION per promo:                                       │
│  • Min/max purchase amount                                   │
│  • Applicable products/categories/brands                     │
│  • Valid date range                                          │
│  • Usage limit (per customer / total / per day)              │
│                                                              │
└──────────────────────────────────────────────────────────────┘
```

---

## 11. End-of-Day Process

```
┌──────────────────────────────────────────────────────────────┐
│                    END OF DAY (Auto: 23:59)                    │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  Scheduled Jobs:                                             │
│                                                              │
│  1. CLOSING CASH DRAWER AUTOMATION                           │
│     • Jika ada shift yang masih open → force close            │
│     • Jika kasir lupa close → system auto-close + flag        │
│                                                              │
│  2. REKAP HARIAN GENERATION                                  │
│     • Total penjualan per outlet                             │
│     • Total transaksi per kasir                              │
│     • Total per metode bayar                                 │
│     • Produk terlaris hari ini                               │
│     • Stok masuk & keluar                                    │
│                                                              │
│  3. LOW STOCK CHECK                                          │
│     • Cek semua produk di bawah min_stock                    │
│     • Generate low stock notification                        │
│     • Auto-suggest PO (jika fitur diaktifkan)                │
│                                                              │
│  4. EXPIRY CHECK                                             │
│     • Cek batch yang akan expired                            │
│     • Generate alert untuk 30/14/7/1 hari                    │
│                                                              │
│  5. BACKUP DATABASE                                          │
│     • mysqldump → storage/backups/                           │
│     • Retensi: 7 hari                                        │
│                                                              │
└──────────────────────────────────────────────────────────────┘
```

---

## 12. End-of-Month Process

```
┌──────────────────────────────────────────────────────────────┐
│                END OF MONTH (Tanggal 1, 00:30)                 │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  1. MEMBERSHIP TIER EVALUATION                               │
│     • Hitung total_spent 6 bulan → upgrade/downgrade tier    │
│     • Kirim notifikasi ke customer                            │
│                                                              │
│  2. COMMISSION CALCULATION                                   │
│     • Hitung komisi semua kasir bulan lalu                   │
│     • Generate komisi report                                 │
│                                                              │
│  3. TAX CALCULATION                                          │
│     • PPN Masukan (dari pembelian)                           │
│     • PPN Keluaran (dari penjualan)                          │
│     • Generate tax report                                    │
│                                                              │
│  4. STOCK OPNAME REMINDER                                    │
│     • Notifikasi ke Manager: saatnya stok opname             │
│                                                              │
│  5. MONTHLY REPORT                                           │
│     • Profit & Loss Statement                                │
│     • Cash Flow Statement                                    │
│     • AR Aging Report                                        │
│     • AP Aging Report                                        │
│     • Sales by Category Report                               │
│                                                              │
│  6. POINT EXPIRY CHECK                                       │
│     • Cek poin customer yang akan expired                    │
│     • Kirim notifikasi                                       │
│                                                              │
└──────────────────────────────────────────────────────────────┘
```

---

## 13. Exception Handling

### 13.1 Void / Cancel Order
```
Order sudah completed → Manager ingin void
  │
  ▼
┌────────────┐
│ Cari Order │
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Alasan     │ ← Input alasan void (wajib)
│ Void       │
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Admin      │ ← Butuh admin permission
│ Approval   │
└─────┬──────┘
      │
      ▼
┌────────────┐
│ Process    │
│ Void       │
│ • Stok kembali bertambah
│ • Payment di-refund (cash/transfer)
│ • Poin dikurangi (jika ada)
│ • Jurnal reversal
│ • Tercatat di audit log
└────────────┘
```

### 13.2 Negative Stock Prevention
```
Saat transaksi POS:
  System cek: current_stock - cart_qty >= 0?
  
  ✅ YES → Lanjut checkout
  ❌ NO  → Tampilkan warning: "Stok tidak mencukupi"
           • Tampilkan stok tersedia
           • Opsi: jual stok yang ada saja (split qty)
           • Atau: batalkan item (remove from cart)
```

### 13.3 Duplicate Payment Prevention
```
Payment masuk via webhook (QRIS/transfer)
  │
  ▼
System cek: reference_number sudah ada di payments?
  ✅ YES → Ignore (duplicate)
  ❌ NO  → Process payment normally
```

### 13.4 Offline POS Conflict Resolution
```
Flutter app transaksi offline → sync ke server
  │
  ▼
Server cek: stok saat ini >= qty transaksi offline?
  
  ✅ YES → Process normally
  ❌ NO  → Mark as conflict
           • Tampilkan di dashboard: "Conflict: Order #INV-xxx"
           • Manager resolve manual:
             - Accept (overwrite stok, stok jadi minus → adjustment)
             - Reject (batalkan transaksi)
```

---

**Dokumen ini adalah living document.** Akan diperbarui seiring feedback dan iterasi development.
