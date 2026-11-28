/**
 * Resolve and work with DOM elements by their HTML id.
 *
 * The root can be the whole document or a specific form/container element.
 * Call refresh() after adding or removing elements dynamically.
 */
export default class ViewBinding {
    constructor(root = null) {
        this.root = root ?? (typeof document !== 'undefined' ? document : null);
        this.elements = Object.create(null);

        this.refresh();
    }

    /**
     * Rebuild the ID map from the current root.
     * Useful when the page adds or removes elements dynamically.
     */
    refresh() {
        this.elements = Object.create(null);

        if (!this.root?.querySelectorAll) return this;

        if (this.root.nodeType === 1 && this.root.id) {
            this.elements[this.root.id] = this.root;
        }

        this.root.querySelectorAll('[id]').forEach((element) => {
            if (element.id) {
                this.elements[element.id] = element;
            }
        });

        return this;
    }

    /** Return an element by ID, or null when it does not exist. */
    get(id) {
        return this.elements[id] ?? null;
    }

    /** Check whether an ID exists inside the current root. */
    has(id) {
        return Boolean(this.get(id));
    }

    /** Return all IDs currently indexed by this instance. */
    getAllIds() {
        return Object.keys(this.elements);
    }

    /**
     * Read a control's value by ID.
     * Checkbox returns a boolean; radio returns the selected value or null;
     * multiple select returns an array; file input returns its FileList.
     */
    getValue(id) {
        const element = this.get(id);
        if (!element) return null;

        if (element.matches('input[type="checkbox"]')) {
            return element.checked;
        }

        if (element.matches('input[type="radio"]')) {
            if (!element.name) return element.checked ? element.value : null;

            const selected = Array.from(
                this.root.querySelectorAll('input[type="radio"]')
            ).find(radio => radio.name === element.name && radio.checked);

            return selected?.value ?? null;
        }

        if (element.matches('select[multiple]')) {
            return Array.from(element.selectedOptions, option => option.value);
        }

        if (element.matches('input[type="file"]')) {
            return element.files;
        }

        return 'value' in element ? element.value : null;
    }

    /**
     * Set a control's value by ID.
     * Returns false for missing elements and file inputs (except clearing them).
     */
    setValue(id, value) {
        const element = this.get(id);
        if (!element) return false;

        if (element.matches('input[type="checkbox"]')) {
            element.checked = typeof value === 'boolean'
                ? value
                : Array.isArray(value)
                    ? value.map(String).includes(String(element.value))
                    : String(value) === String(element.value);
            return true;
        }

        if (element.matches('input[type="radio"]')) {
            if (!element.name) {
                element.checked = String(element.value) === String(value);
                return true;
            }

            const radios = Array.from(
                this.root.querySelectorAll('input[type="radio"]')
            ).filter(radio => radio.name === element.name);

            radios.forEach((radio) => {
                radio.checked = String(radio.value) === String(value);
            });

            return true;
        }

        if (element.matches('select[multiple]')) {
            const selectedValues = new Set(
                (Array.isArray(value) ? value : [value]).map(String)
            );

            Array.from(element.options).forEach((option) => {
                option.selected = selectedValues.has(String(option.value));
            });

            return true;
        }

        if (element.matches('input[type="file"]')) {
            if (value === null || value === '') {
                element.value = '';
                return true;
            }

            return false;
        }

        if (!('value' in element)) return false;

        element.value = value ?? '';
        return true;
    }

}
