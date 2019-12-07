const place = document.querySelectorAll('.hall__place');
const message = document.getElementsByClassName('message')[0];
const num = document.getElementsByClassName('num')[0];

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
                    for (let i = 0; i < data.length; i++) {
                        alert(data[i]);
                    }
                    e.setAttribute('data-status', data);
                    img_place(e.getAttribute('data-status'), e);
                },
            });
        } else {
            message.append('Место занято');
            setTimeout(() => message.innerHTML = '', 2000);
        }
    });
    // e.addEventListener('click', function () {
    //     if(e.getAttribute('data-status') === '1') {
    //         e.setAttribute('data-status', '2');
    //         img_place(e.getAttribute('data-status'), e);
    //     }else {
    //         message.append('Место занято');
    //         setTimeout(() => message.innerHTML = '', 2000);
    //     }
    // });
    // e.addEventListener('dblclick', function () {
    //     if(e.getAttribute('data-status') === '2') {
    //         e.setAttribute('data-status', '1');
    //         img_place(e.getAttribute('data-status'), e);
    //     }else {
    //         message.append('Место уже свободно');
    //         setTimeout(() => message.innerHTML = '', 2000);
    //     }
    // })
});

function img_place(status, e) {
    e.setAttribute('src', 'assets/img/svg/chair_' + status + '.svg');
}