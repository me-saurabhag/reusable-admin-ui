import * as bootstrap from 'bootstrap';

// Expose Bootstrap for legacy host code that uses the global namespace.
window.bootstrap ??= bootstrap;

import './vendor/admin-ui/admin-ui.js';

// Inject the Host application's Toast utility into the package BasePage.
import UIManager from './core/UIManager.js';
window.AdminUiToast ??= UIManager;

// Shared page behaviour (Header actions, and future common page utilities).
import BasePage from './vendor/admin-ui/core/BasePage.js';

// Keep one BasePage instance for the current document.
window.adminBasePage = new BasePage();

// Demo-only Header card live update (runs on / only).
import './pages/header-live-demo.js';

// Reusable input and client-side pagination utilities.
import PinInput from './vendor/admin-ui/inputs/PinInput.js';
import Pagination from './vendor/admin-ui/components/Pagination.js';

window.AdminUiPinInput ??= PinInput;
window.AdminUiPagination ??= Pagination;

// Shared form offcanvas (Host owns the submit handler and API request).
import AdminUiOffcanvas from './vendor/admin-ui/components/Offcanvas.js';
window.AdminUiOffcanvas ??= AdminUiOffcanvas;
AdminUiOffcanvas.initAll();
