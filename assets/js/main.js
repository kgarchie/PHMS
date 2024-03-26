/**
 * @typedef {Object} Patient
 * @property {number} 0 - The patient's ID.
 * @property {string} 1 - The patient's name.
 * @property {string} 2 - The patient's date of birth.
 * @property {string} 3 - The category of the patient (e.g., inpatient).
 * @property {string} 4 - The parent or guardian's name.
 * @property {number} 5 - The parent or guardian's ID.
 * @property {string} name - Alias for the patient's name.
 * @property {string} kid_id - Alias for the patient's ID.
 * @property {string} dob - Alias for the patient's date of birth.
 * @property {string} category - Alias for the patient's category.
 * @property {string} parent_name - Alias for the parent or guardian's name.
 * @property {number} parent_id - Alias for the parent or guardian's ID.
 */

/**
 * @typedef {Object} Parent
 * @property {number} 0 - The parent's ID.
 * @property {string} 1 - The parent's name.
 * @property {string} 2 - The parent's email.
 * @property {string} 3 - The parent's address.
 * @property {string} 4 - The date and time the parent was created.
 * @property {string} 5 - The date and time the parent was last updated.
 * @property {string} 6 - The parent's phone number.
 * @property {number} id - Alias for the parent's ID.
 * @property {string} name - Alias for the parent's name.
 * @property {string} email - Alias for the parent's email.
 * @property {string} address - Alias for the parent's address.
 * @property {string} created_at - Alias for the date and time the parent was created.
 * @property {string} updated_at - Alias for the date and time the parent was last updated.
 * @property {string} phone - Alias for the parent's phone number.
 */

/**
 * @typedef {Object} ParentSearchResult
 * @property {number} 0 - The parent's ID.
 * @property {string} 1 - The parent's name.
 * @property {string} 2 - The parent's email.
 * @property {string} 3 - The parent's phone.
 * @property {string} 4 - The parent's address.
 * @property {number} id - Alias for the parent's ID.
 * @property {string} name - Alias for the parent's name.
 * @property {string} email - Alias for the parent's email.
 * @property {string} address - Alias for the parent's address.
 * @property {string} phone - Alias for the parent's phone number.
 */

/**
 * @typedef {Object} Kid
 * @property {number} 0 - The kid's ID.
 * @property {string} 1 - The kid's name.
 * @property {string} 2 - The kid's date of birth.
 * @property {number} 3 - The parent's ID.
 * @property {string} 4 - The category of the kid.
 * @property {string} 5 - The date and time the kid was created.
 * @property {string} 6 - The date and time the kid was last updated.
 * @property {number} id - Alias for the kid's ID.
 * @property {string} name - Alias for the kid's name.
 * @property {string} dob - Alias for the kid's date of birth.
 * @property {number} parent_id - Alias for the parent's ID.
 * @property {string} category - Alias for the kid's category.
 * @property {string} created_at - Alias for the date and time the kid was created.
 * @property {string} updated_at - Alias for the date and time the kid was last updated.
 */

/**
 * @typedef {Object} ParentAndKids
 * @property {Parent} parent - The parent object.
 * @property {Kid[]} kids - An array of kid objects.
 */

/**
 * @typedef {Object} Doctor
 * @property {number} id
 * @property {string} name
 * @property {string} email
 * @property {phone} phone
 * @property {string} address
 */



function Title(title) {
    document.title = `PHMS | ${title}`
}

function ToastError(message) {
    let toast = document.createElement('section')
    toast.className = 'notification is-danger custom-toast shadow'
    toast.innerHTML = `
        <button class="delete">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="icon">
                <path
                    d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z"></path>
            </svg>
        </button>
        <p>${message}</p>
    `
    document.body.appendChild(toast);
    snuffToasts()
}

function ToastSuccess(message) {
    let toast = document.createElement('section')
    toast.className = 'notification is-success custom-toast shadow'
    toast.innerHTML = `
        <button class="delete">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="icon">
                <path
                    d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z"></path>
            </svg>
        </button>
        <p>${message}</p>
    `
    document.body.appendChild(toast)
    snuffToasts()
}


function snuffToasts() {
    const toasts = document.querySelectorAll('.custom-toast');
    toasts.forEach(toast => {
        toast.querySelector('.delete').addEventListener('click', () => {
            toast.remove();
        });
        const animateInterval = setInterval(() => {
            let opacity = parseFloat(toast.style.opacity || 1);
            opacity -= 0.1;
            toast.style.opacity = `${opacity}`;
        }, 500);
        setTimeout(() => {
            clearInterval(animateInterval);
            toast.remove();
        }, 5000);
    });
}

function stopEvent(event) {
    event.stopPropagation();
    event.preventDefault();
}