$('.slider__items').slick({
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    appendArrows: $(".slider__arrow"),
    prevArrow: $('.slider__prev'),
    nextArrow: $('.slider__next')
});

let elem = {};

dataSet();

const registration = document.querySelector('.auth .registration');
if (registration) {
    registration.addEventListener('click', function () {
        const registrationForm = document.querySelector('.auth .auth__registration');
        const enterForm = document.querySelector('.auth .auth__enter');
        const authDown = document.querySelector('.auth .auth__down');
        const message = document.querySelector('.message');
        if (registrationForm.classList.contains('hidden')) {
            registrationForm.classList.remove('hidden');
            enterForm.classList.add('hidden');
            authDown.style.transform = 'translateY(-200px)';
            registration.innerHTML = 'Войти';
            message.innerHTML = '';

        } else {
            registrationForm.classList.add('hidden');
            enterForm.classList.remove('hidden');
            authDown.removeAttribute('style');
            registration.innerHTML = 'Зарегистрироваться';
            message.innerHTML = '';
        }
    });
}
const enter = document.querySelector('.auth .auth__enter form');

if (enter) {
    enter.addEventListener('submit', function (event) {
        event.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/ajax/auth/enter');
        let formData = new FormData(document.forms.Enter);
        xhr.send(formData);
        xhr.onload = function () {
            if (xhr.status !== 200) {
                log('Ошибка: ' + xhr.status);
            } else {
                let response = JSON.parse(xhr.response);
                let message = document.querySelector('.message');
                message.innerHTML = response['message'];
                setTimeout(() => {
                    location.href = '/';
                }, 2000);
            }
            xhr.onerror = function () {
                log(xhr.response)
            };
        }
    });
}

const registrationForm = document.querySelector('.auth .auth__registration form');

if (registrationForm) {
    registrationForm.addEventListener('submit', function (event) {
        event.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/ajax/auth/registration');
        let formData = new FormData(document.forms.Registration);
        xhr.send(formData);
        xhr.onload = function () {
            if (xhr.status !== 200) {
                log('Ошибка: ' + xhr.status);
            } else {
                let response = JSON.parse(xhr.response);
                let message = document.querySelector('.message');
                message.innerHTML = response['message'];
            }
            xhr.onerror = function () {
                log(xhr.response)
            };
        }
    });
}

const place = document.querySelectorAll('.hall__place');
const buyPlace = document.querySelector('.buyPlace');
let selectPlace = {};

if (place) {
    place.forEach(e => {
        e.addEventListener('click', function () {
            let status = e.getAttribute('data-status');
            let hall_id = e.getAttribute('data-id');
            let message = document.getElementsByClassName('message_' + hall_id)[0];
            let films_id = document.querySelector('#filmsBuy').getAttribute('data-films-id');
            let price = e.getAttribute('data-price');
            const priceElem = document.querySelector('p span.price');

            if (status === '1') {
                if (!e.getAttribute('select')) {
                    selectPlace[e.getAttribute('alt') + hall_id] = {
                        numberPlace: e.getAttribute('alt'),
                        hall_id: hall_id,
                        film_id: films_id
                    };
                    e.style.opacity = '.5';
                    priceElem.innerText = Number(priceElem.innerText) + Number(price);
                    e.setAttribute('select', 'true');
                } else {
                    delete selectPlace[e.getAttribute('alt') + hall_id];
                    e.removeAttribute('style');
                    priceElem.innerText = Number(priceElem.innerText) - Number(price);
                    e.removeAttribute('select');
                }
            } else {
                append(message, 'Место занято', 'true');
            }

            if (Object.keys(selectPlace).length) {
                buyPlace.setAttribute('class', 'btn btn-dark buyPlace');
                buyPlace.removeAttribute('disabled');
            } else {
                buyPlace.setAttribute('class', 'btn btn-outline-dark cursor-not-allows buyPlace');
                buyPlace.setAttribute('disabled', 'true');
            }
        });
    });
}

if (buyPlace) {
    buyPlace.addEventListener('click', function () {
        if (Object.keys(selectPlace).length) {

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/ajax/product/place");
            xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
            xhr.responseType = 'json';
            xhr.send(JSON.stringify({
                selectPlace: selectPlace,
                price: document.querySelector('p span.price').innerText
            }));

            xhr.onload = function () {
                if (xhr.status === 200) {

                } else console.log(`Проихошла ошибка: ${xhr.status} ${xhr.statusText}`);
            };
            xhr.onerror = function () {
                alert(`Ошибка соединения`);
            };
        }
    });
}
let result;


function active(element, classAdd, classRemove)
{
    element = document.querySelectorAll(element);
    element.forEach(item => {
        if (classAdd) {
            if(Array.isArray(classAdd)){
                for (let i = 0; i < classAdd.length; i++) {
                    item.classList.add(classAdd[i]);
                }
            }else{
                item.classList.add(classAdd);
            }

        }
        if (classRemove) {
            if(Array.isArray(classRemove)){
                for (let i = 0; i < classRemove.length; i++) {
                    item.classList.remove(classRemove[i]);
                }
            }else{
                item.classList.remove(classRemove);
            }
        }
    });
}

function removeElement(element)
{
    if (element) {
        element.remove();
    }
}

function img_place(status, e)
{
    e.setAttribute('src', '/app/public/img/svg/chair_' + status + '.svg');
}

function append(elem, text, setTime = '')
{
    elem.innerHTML = '';
    elem.append(text);
    if (setTime !== '')
        setTimeout(() => elem.innerHTML = '', 2000);
}

function log(text)
{
    console.log(text);
}

function dataSet()
{
    let array = document.querySelectorAll('.dataset');

    if (array) {
        array.forEach((element, index) => {
            let attrElement = {};
            let attributes = element.attributes;

            for (let i = attributes.length - 1; i >= 0; i--) {
                if (attributes[i].name.indexOf('data-') + 1) {
                    let name = attributes[i].name.replace('data-', '');
                    attrElement[name] = attributes[i].value;
                    element.removeAttribute(attributes[i].name);
                }
            }

            let id = parseInt(Date.now().toString().slice(-2) + index+(Math.random()*100-1));

            if (element.id) {
                elem[element.id] = {
                    element: element,
                    attr: attrElement
                };
            } else {
                elem[element.tagName.toLowerCase() + '-' + id] = {
                    element: element,
                    attr: attrElement
                };
            }

            element.classList.remove('dataset');
            element.id = element.tagName.toLowerCase() + '-' + id;
        });
    }
}

function searchInObject(elem, object)
{
    if (elem.id) {
        let status = 0;
        let result = 'error';
        for (let element in object) {
            if (element === elem.id) {
                status = 1;
                break;
            }
        }
        if (status) {
            result = object[elem.id];
        }
        return result;
    }
}