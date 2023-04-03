document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.querySelector('.j-form');

    if (contactForm) {
        contactForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(contactForm);
            const response = await fetch('/save-contact', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                },
            });

            if (response.ok) {
                const jsonResponse = await response.json();
                if (jsonResponse.success) {
                    // Обработка успешного сохранения контакта
                    console.log('Контакт успешно сохранен');
                } else {
                    // Обработка ошибки сохранения контакта
                    console.error('Ошибка сохранения контакта:', jsonResponse.message);
                }
            } else {
                // Обработка ошибки HTTP
                console.error('Ошибка HTTP:', response.status);
            }
        });
    }
});