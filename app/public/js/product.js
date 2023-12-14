let data = {
    film: window.location.pathname.split('/').pop(),
    count_free: null,
    price: null,
    select_place: {},
    totalPrice: 0
};

document.addEventListener('click', function (event) {
    dataSet();
    if (event.target.classList.contains('time')) {
        const buyFilms = document.querySelector('#filmBuy');
        let time = event.target;
        active('.time', 'btn-outline-dark', 'btn-dark');
        time.classList.add('btn-dark');
        time.classList.remove('btn-outline-dark');
        data.time = time.dataset.id;
        buyFilms.setAttribute('disabled', true);
        buyFilms.classList.add('btn-outline-dark');
        buyFilms.classList.add('cursor-not-allows');
        buyFilms.classList.remove('btn-dark');
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/ajax/product/halls');
        xhr.send(JSON.stringify({time: time.getAttribute('data-id')}));
        xhr.onload = function () {
            if (xhr.status !== 200) {
                log('Ошибка: ' + xhr.status);
            } else {
                let result = JSON.parse(xhr.response);
                if (result['status']) {
                    const schedule = document.querySelector('.product__schedule');
                    removeElement(document.querySelector('.list'));
                    schedule.insertAdjacentHTML('afterend', result['content']);
                }
            }
            dataSet();
            xhr.onerror = function () {
                log(xhr.response)
            };
        }
    }

    if (event.target.closest('.hall')) {
        active('.hall', 'btn-outline-dark', 'btn-dark');
        let hall = event.target.closest('.hall');
        data.hall = hall.querySelector('span+span').innerText;
        hall.classList.add('btn-dark');
        hall.classList.remove('btn-outline-dark');
        const buyFilms = document.querySelector('#filmBuy');

        buyFilms.removeAttribute('disabled');
        buyFilms.classList.remove('btn-outline-dark');
        buyFilms.classList.remove('cursor-not-allows');
        buyFilms.classList.add('btn-dark');
    }
    if (event.target.closest('#filmBuy')) {

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/ajax/product/hall');
        xhr.send(JSON.stringify(data));
        xhr.onload = function () {
            if (xhr.status !== 200) {
                log('Ошибка: ' + xhr.status);
            } else {
                let result = JSON.parse(xhr.response);
                if (result['status']) {
                    document.querySelector('.modal-body').innerHTML = result['content'];
                } else if (result['error']) {
                    alert(result['error']);
                }
            }
            dataSet();
            refreshVariable();
            xhr.onerror = function () {
                log(xhr.response)
            };
        }
    }
    if (event.target.closest('.place')) {

        let place = searchInObject(event.target.closest('.place'), elem);
        if (Number(place.attr.status) === 0) {
            if (place.element.classList.contains('select-place')) {
                place.element.classList.remove('select-place');
                delete data.select_place[place.attr.number];
                elem['count-place'].element.innerHTML = ++data.count_free;
                data.totalPrice -= Number(data.price);
                elem['total-price'].element.innerHTML = data.totalPrice;
            } else {
                place.element.classList.add('select-place');
                data.select_place[place.attr.number] = true;
                elem['count-place'].element.innerHTML = --data.count_free;
                data.totalPrice += Number(data.price);
                elem['total-price'].element.innerHTML = data.totalPrice;
            }
        } else {
            alert('Место занято');
        }
        if (data.count_free == data.count_max_free) {
            active(
                '#' + elem.button_buy.element.id,
                ['btn-outline-dark', 'cursor-not-allows'],
                'btn-dark');
            elem.button_buy.element.setAttribute('disabled', 'disabled');
        } else {
            active(
                '#' + elem.button_buy.element.id,
                'btn-dark',
                ['btn-outline-dark', 'cursor-not-allows']);
            elem.button_buy.element.removeAttribute('disabled');
        }

    }
    if (event.target === elem.button_buy.element) {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/ajax/product/setPlace');
        xhr.send(JSON.stringify(data));
        xhr.onload = function () {
            if (xhr.status !== 200) {
                log('Ошибка: ' + xhr.status);
            } else {
                let result = JSON.parse(xhr.response);
                if (result['status']) {
                    document.querySelector('.modal-body').innerHTML = result['content'];
                    alert('Вы успешно заняли место/места.')
                } else if (result['error']) {
                    alert(result['error']);
                    if (result['content']) {
                        document.querySelector('.modal-body').innerHTML = result['content'];
                    }
                }
            }
            dataSet();
            refreshVariable();
            xhr.onerror = function () {
                log(xhr.response)
            };
        }
    }
});

function refreshVariable()
{
    data.totalPrice = 0;
    elem['total-price'].element.innerHTML = data.totalPrice;
    data.select_place = {};

    active(
        '#' + elem.button_buy.element.id,
        ['btn-outline-dark', 'cursor-not-allows'],
        'btn-dark');
    elem.button_buy.element.setAttribute('disabled', 'disabled');

    data.count_free = elem['count-place'].attr['count-place'];
    data.count_max_free = elem['count-place'].attr['count-place'];
    data.price = elem['hall-price-' + data.hall].attr.price;

}