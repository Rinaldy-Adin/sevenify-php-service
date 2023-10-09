function basePopup(htmlContent) {
    const popupElement = document.createElement('div');
    popupElement.id = "popup-overlay";
    popupElement.classList.add('popup-overlay');
    popupElement.innerHTML = `
        <div class="popup">
            ${htmlContent}
        </div>
    `;


    document.body.appendChild(popupElement);
    return popupElement;
}

function titledPopup(title, htmlContent) {
    const content = `
        <h2>${title}</h2>
        ${htmlContent}
    `;
    
    return basePopup(content);
}

function confirmCancelPopup(title, message) {
    return new Promise((resolve, reject) => {
        const popupContent = `
            <p class="confirm-popup-msg">${message}</p>
            <div class="confirm-popup-buttons">
                <button id="popup-cancel">Cancel</button>
                <button id="popup-confirm">Confirm</button>
            </div>
        `;

        const popupElement = titledPopup(title, popupContent);

        const cancelButton = document.getElementById('popup-cancel');
        const confirmButton = document.getElementById('popup-confirm');

        confirmButton.addEventListener('click', () => {
            document.body.removeChild(popupElement);
            resolve();
        });

        cancelButton.addEventListener('click', () => {
            document.body.removeChild(popupElement);
            reject();
        });
    });
}