# Implementation Update v0.3.2 — Form Inputs

## Included
- Dedicated Form Inputs showcase page (`resources/views/pages/form-inputs.blade.php`).
- Demonstrations for common HTML input types, sizes, appearances, labels, helper text, validation, disabled/read-only states, selects and textareas.
- Textarea now supports `size="sm|md|lg"`, matching Input and Select.
- Removed a duplicate appearance class in the Select component.
- Responsive showcase styling appended to `resources/css/admin-ui.css`.

## Host route
```php
Route::view('/admin-ui/form-inputs', 'admin-ui::pages.form-inputs')
    ->name('admin-ui.form-inputs');
```

## Notes
- No new dependencies or build tools.
- Sidebar and Header are unchanged.
- Input Groups, Radio/Checkbox and other families remain separate future updates.
