import Toast from './Toast.js';

/**
 * Open an image upload component and return the selected image through a callback.
 *
 * The supplied element can be either the file input itself or a wrapper
 * containing an input[type="file"].
 *
 * @param {HTMLElement} element Image upload component or file input.
 * @param {(file: File) => void} callback Called with the selected image.
 * @param {Object} options
 * @param {number} [options.maxSize=5242880] Maximum file size in bytes.
 * @param {() => void} [options.onCancel] Called when the picker is cancelled.
 * @param {(message: string, file?: File) => void} [options.onError] Called when validation fails.
 * @returns {HTMLInputElement|null} The file input, when available.
 */
export default function chooseImage(
    element,
    callback,
    {
        maxSize = 5 * 1024 * 1024,
        onCancel,
        onError,
    } = {}
) {
    if (!element || typeof element.querySelector !== 'function') {
        console.error('A valid image upload element is required.');
        return null;
    }

    if (typeof callback !== 'function') {
        console.error('A valid image selection callback is required.');
        return null;
    }

    const input = element.matches?.('input[type="file"]')
        ? element
        : element.querySelector('input[type="file"]');

    if (!input) {
        console.error('File input not found in the image upload component.');
        return null;
    }

    let settled = false;

    const cleanup = () => {
        input.removeEventListener('change', handleChange);
        input.removeEventListener('cancel', handleCancel);
    };

    const fail = (message, file = null) => {
        if (settled) return;

        settled = true;
        cleanup();

        Toast.error(message, 'Invalid image');
        onError?.(message, file ?? undefined);
    };

    const handleChange = () => {
        if (settled) return;

        const file = input.files?.[0];

        if (!file) {
            handleCancel();
            return;
        }

        if (!file.type || !file.type.startsWith('image/')) {
            fail('Please select a valid image file.', file);
            return;
        }

        const allowedMaxSize = Number(maxSize);

        if (
            Number.isFinite(allowedMaxSize) &&
            allowedMaxSize > 0 &&
            file.size > allowedMaxSize
        ) {
            const maxSizeInMb = (allowedMaxSize / (1024 * 1024))
                .toFixed(2)
                .replace(/\.00$/, '');

            fail(`Image size must not exceed ${maxSizeInMb} MB.`, file);
            return;
        }

        settled = true;
        cleanup();

        callback(file);
    };

    const handleCancel = () => {
        if (settled) return;

        settled = true;
        cleanup();

        onCancel?.();
    };

    input.addEventListener('change', handleChange);
    input.addEventListener('cancel', handleCancel, { once: true });

    input.click();

    return input;
}
