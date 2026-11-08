# Design Tokens

The framework's default design tokens are split into small CSS files under
`resources/css/tokens/` and imported by `resources/css/admin-ui.css`.

| File | Responsibility |
|---|---|
| `colors.css` | Brand, semantic, neutral, interaction and sidebar colors |
| `typography.css` | Inter font stack, type scale, weights and line heights |
| `spacing.css` | 4px-based spacing scale |
| `dimensions.css` | Control, card, table, dialog, offcanvas and shell dimensions |
| `radius.css` | Border widths and corner radius scale |
| `shadows.css` | Elevation and transition tokens |

## Host application overrides

Override documented `--rai-*` variables in a stylesheet loaded after the
package stylesheet. Do not edit package token files just to customize one
application's brand.

```css
:root {
    --rai-primary: #2457a6;
    --rai-primary-hover: #1d4788;
    --rai-primary-active: #17396d;
}
```

The framework currently retains the `rai-` namespace to avoid breaking
existing Sidebar, Header and page components. A namespace migration is not
part of this update.
