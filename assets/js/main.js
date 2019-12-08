const place = document.querySelectorAll('.hall__place');
const message = document.getElementsByClassName('message')[0];
const available = document.getElementsByClassName('available')[0];

place.forEach(e => {
    e.addEventListener('click', function () {
        let status = e.getAttribute('data-status');
        if (status == '1') {
            let id = e.getAttribute('alt');
            let hall_id = e.getAttribute('data-id');
            $.ajax({
                type: "POST",
                url: "/assets/php/PlaceController.php",
                data: {status: status, id: id, hall_id: hall_id},
                success: function (data) {
                    e.setAttribute('data-status', JSON.parse(data).statufs);
                    img_place(e.getAttribute('data-status'), e);
                    append(available, JSON.parse(data).available);
                },
            });
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