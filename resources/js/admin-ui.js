/* Reusable Admin UI — dependency-free browser runtime. */
(function (window, document) {
    'use strict';
    var initializedRoots = new WeakMap();
    var desktopQuery = window.matchMedia('(min-width: 992px)');

    function closeMobile(root, returnFocus) {
        root.setAttribute('data-rai-sidebar-open', 'false');
        if (!document.querySelector('.rai-ui[data-rai-sidebar-open="true"]')) document.body.style.overflow = '';
        var opener = root.querySelector('[data-rai-sidebar-toggle]');
        if (opener) {
            opener.setAttribute('aria-expanded', 'false');
            if (returnFocus) opener.focus();
        }
    }

    function handleClick(event) {
        if (!(event.target instanceof Element)) return;
        var toggle = event.target.closest('[data-rai-sidebar-toggle]');
        var close = event.target.closest('[data-rai-sidebar-close]');
        var root = event.target.closest('.rai-ui');

        if (toggle && root) {
            if (desktopQuery.matches) {
                var collapsed = root.getAttribute('data-rai-sidebar-collapsed') !== 'true';
                root.setAttribute('data-rai-sidebar-collapsed', collapsed ? 'true' : 'false');
                toggle.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
            } else {
                var open = root.getAttribute('data-rai-sidebar-open') !== 'true';
                root.setAttribute('data-rai-sidebar-open', open ? 'true' : 'false');
                document.body.style.overflow = open ? 'hidden' : '';
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                if (open) {
                    var first = root.querySelector('.rai-ui__sidebar a, .rai-ui__sidebar button');
                    if (first) first.focus({ preventScroll: true });
                }
            }
            return;
        }

        if (close && root) {
            closeMobile(root, true);
            return;
        }

        var submenuToggle = event.target.closest('[data-rai-submenu-toggle]');
        if (submenuToggle && root) {
            if (desktopQuery.matches && root.getAttribute('data-rai-sidebar-collapsed') === 'true') {
                root.setAttribute('data-rai-sidebar-collapsed', 'false');
                var sidebarToggle = root.querySelector('[data-rai-sidebar-toggle]');
                if (sidebarToggle) sidebarToggle.setAttribute('aria-expanded', 'true');
            }
            var group = submenuToggle.closest('[data-rai-nav-group]');
            var submenu = group && group.querySelector('.rai-ui__submenu');
            var willOpen = submenuToggle.getAttribute('aria-expanded') !== 'true';
            root.querySelectorAll('[data-rai-submenu-toggle]').forEach(function (otherToggle) {
                if (otherToggle === submenuToggle) return;
                otherToggle.setAttribute('aria-expanded', 'false');
                var otherGroup = otherToggle.closest('[data-rai-nav-group]');
                var otherSubmenu = otherGroup && otherGroup.querySelector('.rai-ui__submenu');
                if (otherSubmenu) otherSubmenu.hidden = true;
            });
            submenuToggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            if (submenu) submenu.hidden = !willOpen;
            return;
        }

        var navLink = event.target.closest('.rai-ui__sidebar a.rai-ui__nav-link');
        if (navLink && root && !desktopQuery.matches) {
            closeMobile(root, false);
            var opener = root.querySelector('[data-rai-sidebar-toggle]');
            if (opener) opener.setAttribute('aria-expanded', 'false');
        }

        var trigger = event.target.closest('[data-rai-dismiss]');
        if (trigger) {
            var dismissible = trigger.closest('[data-rai-dismissible]');
            if (dismissible) dismissible.remove();
        }
    }

    function handleKeydown(event) {
        if (event.key !== 'Escape') return;
        document.querySelectorAll('.rai-ui[data-rai-sidebar-open="true"]').forEach(function (root) {
            closeMobile(root, true);
        });
    }

    function handleBreakpointChange() {
        document.querySelectorAll('.rai-ui').forEach(function (root) {
            if (desktopQuery.matches) {
                closeMobile(root, false);
                var opener = root.querySelector('[data-rai-sidebar-toggle]');
                if (opener) opener.setAttribute('aria-expanded', root.getAttribute('data-rai-sidebar-collapsed') === 'true' ? 'false' : 'true');
            } else {
                var mobileOpener = root.querySelector('[data-rai-sidebar-toggle]');
                if (mobileOpener) mobileOpener.setAttribute('aria-expanded', root.getAttribute('data-rai-sidebar-open') === 'true' ? 'true' : 'false');
            }
        });
    }

    function init(root) {
        var target = root || document;
        if (initializedRoots.has(target)) return;
        target.addEventListener('click', handleClick);
        target.addEventListener('keydown', handleKeydown);
        initializedRoots.set(target, true);
        if (desktopQuery.addEventListener) desktopQuery.addEventListener('change', handleBreakpointChange);
        else if (desktopQuery.addListener) desktopQuery.addListener(handleBreakpointChange);
        handleBreakpointChange();
    }

    function dispose(root) {
        var target = root || document;
        if (!initializedRoots.has(target)) return;
        target.removeEventListener('click', handleClick);
        target.removeEventListener('keydown', handleKeydown);
        initializedRoots.delete(target);
        if (desktopQuery.removeEventListener) desktopQuery.removeEventListener('change', handleBreakpointChange);
        else if (desktopQuery.removeListener) desktopQuery.removeListener(handleBreakpointChange);
    }

    function emitHeaderAction(action, detail) {
        document.dispatchEvent(new CustomEvent('admin-ui:header-action', {
            bubbles: true,
            detail: Object.assign({ action: action }, detail || {})
        }));
    }

    function normalizeCardValue(data) {
        if (data === null || data === undefined) return '—';
        if (typeof data !== 'object' || Array.isArray(data)) return String(data);
        var value = data.value;
        if (value === null || value === undefined) return '—';
        if (data.format === 'currency' && typeof value === 'number') {
            try {
                return new Intl.NumberFormat(data.locale || undefined, {
                    style: 'currency',
                    currency: data.currency || 'INR',
                    minimumFractionDigits: data.decimals === undefined ? 2 : data.decimals,
                    maximumFractionDigits: data.decimals === undefined ? 2 : data.decimals
                }).format(value);
            } catch (error) { return String(value); }
        }
        if (data.format === 'number' && typeof value === 'number') {
            value = new Intl.NumberFormat(data.locale || undefined, {
                maximumFractionDigits: data.decimals === undefined ? 2 : data.decimals
            }).format(value);
        }
        return String(value) + (data.suffix ? ' ' + data.suffix : '');
    }

    function updateCard(key, data) {
        var selector = '[data-rai-info-card="' + String(key).replace(/"/g, '\\"') + '"]';
        document.querySelectorAll(selector).forEach(function (card) {
            var value = card.querySelector('[data-rai-card-value]');
            if (value) value.textContent = normalizeCardValue(data);
        });
    }

    function setCardData(cards) {
        if (!cards || typeof cards !== 'object') return;
        Object.keys(cards).forEach(function (key) { updateCard(key, cards[key]); });
    }

    function closeProfileMenu(profile, returnFocus) {
        if (!profile) return;
        var toggle = profile.querySelector('[data-rai-profile-toggle]');
        var menu = profile.querySelector('[data-rai-profile-menu]');
        if (menu) menu.hidden = true;
        if (toggle) {
            toggle.setAttribute('aria-expanded', 'false');
            if (returnFocus) toggle.focus();
        }
    }

    function handleProfileMenuClick(event) {
        if (!(event.target instanceof Element)) return;

        var toggle = event.target.closest('[data-rai-profile-toggle]');
        if (toggle) {
            var profile = toggle.closest('[data-rai-profile]');
            var menu = profile && profile.querySelector('[data-rai-profile-menu]');
            if (!menu) return;
            if (menu.id) toggle.setAttribute('aria-controls', menu.id);
            toggle.setAttribute('aria-haspopup', 'menu');
            var willOpen = menu.hidden;
            document.querySelectorAll('[data-rai-profile]').forEach(function (other) {
                if (other !== profile) closeProfileMenu(other, false);
            });
            menu.hidden = !willOpen;
            toggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            return;
        }

        var action = event.target.closest('[data-rai-profile-action]');
        if (action) {
            var owner = action.closest('[data-rai-profile]');
            var actionKey = action.getAttribute('data-rai-profile-action');
            closeProfileMenu(owner, false);
            document.dispatchEvent(new CustomEvent('admin-ui:profile-action', {
                detail: { action: actionKey, element: action }
            }));
            return;
        }

        if (!event.target.closest('[data-rai-profile]')) {
            document.querySelectorAll('[data-rai-profile]').forEach(function (profile) {
                closeProfileMenu(profile, false);
            });
        }
    }

    function handleProfileMenuKeydown(event) {
        if (event.key !== 'Escape') return;
        var openMenu = document.querySelector('[data-rai-profile-menu]:not([hidden])');
        if (openMenu) {
            event.preventDefault();
            closeProfileMenu(openMenu.closest('[data-rai-profile]'), true);
        }
    }

    function handleHeaderActionClick(event) {
        if (!(event.target instanceof Element)) return;
        var button = event.target.closest('[data-rai-header-action]');
        if (!button) return;
        emitHeaderAction(button.getAttribute('data-rai-header-action'));
    }

    document.addEventListener('click', function (event) {
        if (!(event.target instanceof Element)) return;
        var removeButton = event.target.closest('[data-rai-tag-remove]');
        if (!removeButton) return;
        var tag = removeButton.closest('.rai-tag');
        if (!tag || removeButton.disabled) return;
        var detail = { tag: tag, value: tag.textContent.trim() };
        tag.dispatchEvent(new CustomEvent('rai:tag:remove', { bubbles: true, detail: detail }));
        tag.remove();
    });


    function closeDropdown(dropdown, returnFocus) {
        if (!dropdown) return;
        var menu = dropdown.querySelector('[data-rai-dropdown-menu]');
        var toggle = dropdown.querySelector('[data-rai-dropdown-toggle]');
        if (menu) menu.hidden = true;
        dropdown.classList.remove('is-open');
        if (toggle) {
            toggle.setAttribute('aria-expanded', 'false');
            if (returnFocus) toggle.focus();
        }
    }

    function closeAllDropdowns(except, returnFocus) {
        document.querySelectorAll('[data-rai-dropdown].is-open').forEach(function (dropdown) {
            if (dropdown !== except) closeDropdown(dropdown, returnFocus && dropdown === except);
        });
    }

    function handleDropdownClick(event) {
        if (!(event.target instanceof Element)) return;
        var toggle = event.target.closest('[data-rai-dropdown-toggle]');
        if (toggle) {
            var dropdown = toggle.closest('[data-rai-dropdown]');
            var menu = dropdown && dropdown.querySelector('[data-rai-dropdown-menu]');
            if (!menu) return;
            if (menu.id) toggle.setAttribute('aria-controls', menu.id);
            toggle.setAttribute('aria-haspopup', 'menu');
            var willOpen = menu.hidden;
            closeAllDropdowns(dropdown, false);
            menu.hidden = !willOpen;
            dropdown.classList.toggle('is-open', willOpen);
            toggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            if (willOpen) {
                var firstItem = menu.querySelector('[role="menuitem"]:not([disabled]):not([aria-disabled="true"])');
                if (firstItem) firstItem.focus({ preventScroll: true });
            }
            return;
        }
        var item = event.target.closest('[data-rai-dropdown] [role="menuitem"]');
        if (item && !item.matches('[disabled], [aria-disabled="true"]')) {
            closeDropdown(item.closest('[data-rai-dropdown]'), false);
            return;
        }
        if (!event.target.closest('[data-rai-dropdown]')) closeAllDropdowns(null, false);
    }

    function handleDropdownKeydown(event) {
        if (!(event.target instanceof Element)) return;
        var dropdown = event.target.closest('[data-rai-dropdown]');
        if (!dropdown) return;
        var menu = dropdown.querySelector('[data-rai-dropdown-menu]');
        if (event.key === 'Escape' && menu && !menu.hidden) {
            event.preventDefault();
            closeDropdown(dropdown, true);
            return;
        }
        if (!menu || menu.hidden || !['ArrowDown', 'ArrowUp', 'Home', 'End'].includes(event.key)) return;
        var items = Array.prototype.slice.call(menu.querySelectorAll('[role="menuitem"]:not([disabled]):not([aria-disabled="true"])'));
        if (!items.length) return;
        event.preventDefault();
        var index = items.indexOf(document.activeElement);
        if (event.key === 'Home') index = 0;
        else if (event.key === 'End') index = items.length - 1;
        else if (event.key === 'ArrowDown') index = (index + 1) % items.length;
        else index = (index - 1 + items.length) % items.length;
        items[index].focus();
    }

    function handleAccordionClick(event) {
        if (!(event.target instanceof Element)) return;
        var trigger = event.target.closest('[data-rai-accordion-trigger]');
        if (!trigger || trigger.disabled) return;
        var item = trigger.closest('[data-rai-accordion-item]');
        var accordion = trigger.closest('[data-rai-accordion]');
        var panel = item && item.querySelector('[data-rai-accordion-panel]');
        if (!item || !accordion || !panel) return;
        var willOpen = panel.hidden;
        if (willOpen && accordion.getAttribute('data-rai-accordion-mode') === 'single') {
            accordion.querySelectorAll('[data-rai-accordion-item]').forEach(function (otherItem) {
                if (otherItem === item) return;
                var otherPanel = otherItem.querySelector('[data-rai-accordion-panel]');
                var otherTrigger = otherItem.querySelector('[data-rai-accordion-trigger]');
                if (otherPanel) otherPanel.hidden = true;
                if (otherTrigger) otherTrigger.setAttribute('aria-expanded', 'false');
                otherItem.classList.remove('is-open');
            });
        }
        panel.hidden = !willOpen;
        trigger.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
        item.classList.toggle('is-open', willOpen);
        item.dispatchEvent(new CustomEvent('rai:accordion:toggle', { bubbles: true, detail: { open: willOpen } }));
    }

    document.addEventListener('click', handleDropdownClick);
    document.addEventListener('keydown', handleDropdownKeydown);
    document.addEventListener('click', handleAccordionClick);

    document.addEventListener('click', handleHeaderActionClick);
    document.addEventListener('click', handleProfileMenuClick);
    document.addEventListener('keydown', handleProfileMenuKeydown);

    window.AdminUi = Object.freeze({
        version: '0.5.0',
        init: init,
        dispose: dispose,
        header: Object.freeze({
            emit: emitHeaderAction,
            setCardData: setCardData,
            updateCard: updateCard,
            updateCards: setCardData
        })
    });
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function () { init(document); }, { once: true });
    else init(document);
}(window, document));
