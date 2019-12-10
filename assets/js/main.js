const place = document.querySelectorAll('.hall__place');
const message = document.getElementsByClassName('message')[0];
const available = document.getElementsByClassName('available')[0];

place.forEach(e => {
    e.addEventListener('click', function () {
        let status = e.getAttribute('data-status');
        if (status == '1') {
            let formData = new FormData();
            formData.append("status", status);
            formData.append("id", e.getAttribute('alt'));
            formData.append("hall_id", e.getAttribute('data-id'));

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/assets/php/PlaceController.php");
            xhr.send(formData);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log(xhr.response);
                    e.setAttribute('data-status', JSON.parse(xhr.response).status);
                    img_place(e.getAttribute('data-status'), e);
                    append(available, JSON.parse(xhr.response).available);
                } else console.log(`Проихошла ошибка: ${xhr.status} ${xhr.statusText}`);
            };
            xhr.onerror = function () {
                alert(`Ошибка соединения`);
            };
        } else {
            append(message, 'Место занято', 'true');
        }
    });
});

function img_place(status, e) {
    e.setAttribute('src', 'assets/img/svg/chair_' + status + '.svg');
}

function append(elem, text, setTime = '') {
    elem.innerHTML = '';
    elem.append(text);
    if (setTime != '')
        setTimeout(() => elem.innerHTML = '', 2000);
}