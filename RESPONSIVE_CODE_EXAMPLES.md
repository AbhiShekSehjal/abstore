# Responsive Code Examples - Reference Guide

## Media Query Structure Used in All Files

```css
/* Desktop - 992px and above (UNCHANGED) */
@media (min-width: 992px) {
    /* Original styles apply */
}

/* Tablets - 576px to 991px */
@media (max-width: 991px) {
    h1 { font-size: 1.5rem; }
    .table { font-size: 0.9rem; }
    .row.g-3 { gap: 0.75rem !important; }
}

/* Mobile - Below 576px */
@media (max-width: 575.98px) {
    .container { padding-left: 10px; padding-right: 10px; }
    h1 { font-size: 1.2rem; }
    .table { font-size: 0.85rem; }
    .table th, .table td { padding: 0.25rem 0.15rem !important; }
    .row.g-3 { flex-direction: column; gap: 0.5rem !important; }
    .row.g-3 > div { width: 100% !important; }
}
```

---

## Responsive Grid Patterns Used

### **Pattern 1: Search and Sort Controls**
```html
<!-- Desktop: 3 columns (6+3+3) | Tablet: 2 columns (6+6) | Mobile: Stacked -->
<div class="row g-3">
    <div class="col-12 col-md-6 col-lg-6">
        <!-- Search control -->
        <form class="d-flex gap-2">
            <input type="text" class="form-control" placeholder="Search...">
            <button class="btn btn-dark">Search</button>
        </form>
    </div>
    
    <div class="col-12 col-md-3 col-lg-3">
        <!-- Sort dropdown -->
        <form class="d-flex">
            <select class="form-select">
                <option>Sort By</option>
            </select>
        </form>
    </div>
    
    <div class="col-12 col-md-3 col-lg-3">
        <!-- Add button -->
        <button class="btn btn-primary w-100">Add Item</button>
    </div>
</div>
```

### **Pattern 2: Responsive Table**
```html
<!-- Wraps table for horizontal scroll on mobile -->
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Column 1</th>
                <th>Column 2</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Data</td>
                <td>Data</td>
                <td>
                    <button class="btn btn-sm">Edit</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<style>
    @media (max-width: 575.98px) {
        .table { font-size: 0.85rem; }
        .table th, .table td { padding: 0.25rem !important; }
        .btn { font-size: 0.7rem; padding: 0.25rem 0.5rem; }
    }
</style>
```

### **Pattern 3: Dashboard Cards**
```html
<!-- Desktop: 3 cards per row | Tablet: 2 per row | Mobile: 1 per row -->
<div class="row">
    <a href="/admin/products" 
       class="col-12 col-md-6 col-lg-4 bg-secondary p-5 text-white">
        <h3>Products</h3>
        <h2>{{ $count }}</h2>
    </a>
    
    <a href="/admin/categories" 
       class="col-12 col-md-6 col-lg-4 bg-secondary p-5 text-white">
        <h3>Categories</h3>
        <h2>{{ $count }}</h2>
    </a>
    
    <a href="/admin/orders" 
       class="col-12 col-md-6 col-lg-4 bg-secondary p-5 text-white">
        <h3>Orders</h3>
        <h2>{{ $count }}</h2>
    </a>
</div>

<style>
    @media (max-width: 575.98px) {
        .col-12 { margin-bottom: 1rem; }
        h3 { font-size: 1.2rem; }
        h2 { font-size: 1.5rem; }
    }
</style>
```

### **Pattern 4: Form Layout**
```html
<!-- Desktop: 3 columns | Tablet: 2 columns | Mobile: Full width stacked -->
<div class="row">
    <div class="col-12 col-md-6 col-lg-4">
        <label class="form-label">Instagram Link</label>
        <input type="text" class="form-control">
    </div>
    
    <div class="col-12 col-md-6 col-lg-4">
        <label class="form-label">Facebook Link</label>
        <input type="text" class="form-control">
    </div>
    
    <div class="col-12 col-md-6 col-lg-4">
        <label class="form-label">Twitter Link</label>
        <input type="text" class="form-control">
    </div>
</div>

<style>
    @media (max-width: 575.98px) {
        .form-control { font-size: 0.9rem; }
        .form-label { font-size: 0.95rem; }
    }
</style>
```

---

## Font Size Scaling Examples

### **Heading Sizes**
```css
/* Desktop */
h1 { font-size: 2rem; }
h2 { font-size: 1.5rem; }
h3 { font-size: 1.25rem; }

/* Tablet */
@media (max-width: 991px) {
    h1 { font-size: 1.5rem; }
    h2 { font-size: 1.25rem; }
    h3 { font-size: 1.1rem; }
}

/* Mobile */
@media (max-width: 575.98px) {
    h1 { font-size: 1.2rem; }
    h2 { font-size: 1rem; }
    h3 { font-size: 0.9rem; }
}
```

### **Table Sizes**
```css
/* Desktop */
.table { font-size: 1rem; }
.table th, .table td { padding: 0.75rem; }
.btn { padding: 0.375rem 0.75rem; font-size: 1rem; }

/* Tablet */
@media (max-width: 991px) {
    .table { font-size: 0.9rem; }
    .table th, .table td { padding: 0.5rem; }
    .btn { padding: 0.35rem 0.6rem; font-size: 0.9rem; }
}

/* Mobile */
@media (max-width: 575.98px) {
    .table { font-size: 0.85rem; }
    .table th, .table td { padding: 0.25rem; }
    .btn { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
}
```

---

## Image Scaling Examples

### **Thumbnail Images (Product/Category)**
```css
/* Desktop */
.productImage {
    width: 50px;
    height: 50px;
    object-fit: cover;
}

/* Tablet */
@media (max-width: 991px) {
    .productImage {
        width: 40px;
        height: 40px;
    }
}

/* Mobile */
@media (max-width: 575.98px) {
    .productImage {
        width: 35px;
        height: 35px;
    }
}
```

### **Chart Containers**
```css
/* Desktop */
.pie-chart-wrapper {
    max-width: 280px;
    margin: 0 auto;
}

/* Tablet */
@media (max-width: 991px) {
    .pie-chart-wrapper {
        max-width: 200px;
    }
}

/* Mobile */
@media (max-width: 575.98px) {
    .pie-chart-wrapper {
        max-width: 150px;
    }
}
```

---

## Flex Layout Responsive Examples

### **Header with Title and Controls**
```html
<!-- Desktop: Flex row | Tablet: Flex row | Mobile: Flex column -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1>Dashboard</h1>
    </div>
    
    <div class="row g-3">
        <div class="col-auto">
            <input type="search" class="form-control">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Search</button>
        </div>
    </div>
</div>

<style>
    @media (max-width: 575.98px) {
        .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }
        
        .row {
            width: 100%;
        }
        
        .col-auto {
            width: 100% !important;
        }
    }
</style>
```

---

## Modal Responsiveness

### **Mobile-Friendly Modal**
```html
<div class="modal fade" id="exampleModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Form content -->
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 575.98px) {
        .modal-body {
            padding: 1rem 0.75rem;
        }
        
        .form-control, .form-select {
            font-size: 0.9rem;
        }
        
        .btn {
            width: 100%;
            margin-top: 0.5rem;
        }
    }
</style>
```

---

## Common Responsive Classes Reference

| Class | Purpose |
|-------|---------|
| `.table-responsive` | Adds horizontal scroll to tables on small screens |
| `.col-12` | Full width on all screens |
| `.col-md-6` | 50% width on tablets and up |
| `.col-lg-4` | 33% width on desktops and up |
| `.d-flex` | Flexbox container |
| `.flex-direction-column` | Stack items vertically (mobile) |
| `.gap-3` | Add spacing between flex items |
| `@media (max-width: Xpx)` | Apply styles to specific breakpoints |

---

## Testing Media Queries

### **In Chrome DevTools:**
1. Open DevTools (F12)
2. Click device toggle button (Ctrl+Shift+M)
3. Test these widths:
   - 320px (Mobile)
   - 576px (Small tablet)
   - 768px (Tablet)
   - 992px (Large tablet)
   - 1920px (Desktop)

### **Common Breakpoints:**
```
320px  - Small mobile
375px  - Standard mobile
425px  - Large mobile
576px  - Small tablet
768px  - Tablet
992px  - Large tablet
1200px - Desktop
1920px - Large desktop
```

---

## Performance Tips

✅ **CSS Only** - No JavaScript needed for responsiveness
✅ **Mobile First** - Styles progressively enhance
✅ **Lightweight** - Minimal additional CSS
✅ **Fast** - No image resizing, just scaling
✅ **SEO Safe** - No changes to HTML structure

All responsive designs use CSS media queries and Bootstrap's responsive grid system for optimal performance!
