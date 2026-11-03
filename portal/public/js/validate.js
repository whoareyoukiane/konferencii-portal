// проверка форм в браузере, те же правила, что на сервере (src/Validator.php)
// сервер всё равно проверяет заново

var rules = {
    login: function (v) {
        return /^[A-Za-z0-9_]{3,20}$/.test(v) ? '' : 'Логин: от 3 до 20 символов, латиница, цифры и «_»';
    },
    email: function (v) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) ? '' : 'Введите почту в формате name@site.ru';
    },
    phone: function (v) {
        var digits = v.replace(/\D/g, '');
        var ok = digits.length === 11 && (digits[0] === '7' || digits[0] === '8');
        return ok ? '' : 'Телефон в формате +7 900 123-45-67';
    },
    password: function (v) {
        return v.length >= 8 ? '' : 'Пароль не короче 8 символов';
    },
    event_id: function (v) {
        return v ? '' : 'Выберите мероприятие';
    },
    room: function (v) {
        return v ? '' : 'Выберите помещение';
    },
    payment: function (v) {
        return v ? '' : 'Выберите способ оплаты';
    }
};

// какие поля проверяем на какой форме
var forms = {
    register: ['login', 'email', 'phone', 'password'],
    login: [],
    request: ['event_id', 'room', 'payment']
};

function showError(input, text) {
    var field = input.closest('.field');
    field.classList.toggle('bad', text !== '');
    var box = field.querySelector('.err');
    if (box) {
        box.textContent = text;
    }
}

function checkField(form, name) {
    var input = form.elements[name];
    var text = rules[name](input.value.trim());
    showError(input, text);
    return text === '';
}

document.querySelectorAll('form[data-validate]').forEach(function (form) {
    var names = forms[form.dataset.validate] || [];

    names.forEach(function (name) {
        form.elements[name].addEventListener('blur', function () {
            checkField(form, name);
        });
    });

    form.addEventListener('submit', function (event) {
        var allOk = true;
        var firstBad = null;
        names.forEach(function (name) {
            if (!checkField(form, name)) {
                allOk = false;
                firstBad = firstBad || form.elements[name];
            }
        });
        if (!allOk) {
            event.preventDefault();
            firstBad.focus();
        }
    });
});
