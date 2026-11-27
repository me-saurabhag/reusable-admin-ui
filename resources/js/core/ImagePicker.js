import Toast from './Toast.js';

/**
 * Open the native image picker and return a validated File through callbacks.
 *
 * @param {Object} options
 * @param {string} [options.accept]
 * @param {number} [options.maxSize] Maximum file size in bytes.
 * @param {(file: File) => void} [options.onSelect]
 * @param {() => void} [options.onCancel]
 * @param {(message: string, file?: File) => void} [options.onError]
 * @returns {HTMLInputElement|null} The temporary file input, when available.
 */
export default function chooseImage({
    accept = 'image/jpeg,image/png,image/webp',
    maxSize = 5 * 1024 * 1024,
    onSelect,
    onCancel,
    onError,
} = {}) {
    if (typeof document === 'undefined' || !document.body) return null;

    const input = document.createElement('input');
    let settled = false;

    input.type = 'file';
    input.accept = accept;
    input.hidden = true;
    input.setAttribute('aria-hidden', 'true');
    document.body.appendChild(input);

    const cleanup = () => {
        if (input.isConnected) input.remove();
    };

    const fail = (message, file = null) => {
        if (settled) return;
        settled = true;
        cleanup();
        Toast.error(message, 'Invalid image');
        onError?.(message, file ?? undefined);
    };

    input.addEventListener('change', () => {
        if (settled) return;

        const file = input.files?.[0];

        if (!file) {
            settled = true;
            cleanup();
            onCancel?.();
            return;
        }

        if (!file.type || !file.type.startsWith('image/')) {
            fail('Please select a valid image file.', file);
            return;
        }

        const allowedMaxSize = Number(maxSize);
        if (Number.isFinite(allowedMaxSize) && allowedMaxSize > 0 && file.size > allowedMaxSize) {
            const maxSizeInMb = (allowedMaxSize / (1024 * 1024)).toFixed(2).replace(/\.00$/, '');
            fail(`Image size must not exceed ${maxSizeInMb} MB.`, file);
            return;
        }

        settled = true;
        cleanup();
        onSelect?.(file);
    }, { once: true });

    input.addEventListener('cancel', () => {
        if (settled) return;
        settled = true;
        cleanup();
        onCancel?.();
    }, { once: true });

    input.click();

    return input;
}
