
class WheelConroller {
    // Дебаг мод
    static debug_mod = false;

    // Колесо
    static wheel = document.querySelector('#wheel');

    // Время действия анимации
    static animation_time = 8;

    // Информация о выйграшном предмете
    static reward_item_info = null;

    // Секторы
    static wheel_sectors = document.querySelector('#wheel .wheel__container');

    // Кнопка "Start Game"
    static play_button = document.querySelector('#wheel-button');

    // Элементы блока с прогрессбаром
    static processing_box = document.querySelector('#wheel-processing');
    static processing_bar = document.querySelector('#wheel-processing .wheel-result__brogress-bar');

    // Блок с выйграшным предметом (появляется после вращения колеса)
    static reward_item_box = document.querySelector('#wheel-reward');

    // Кнопка обновления колеса
    static update_button = document.querySelector('#wheel-update');

    // Блок со всеми возможными выйграшами
    static rewards_box = document.querySelector('#wheel-rewards');

    update(data){
        WheelConroller.updateItems(data.items);
        WheelConroller.updateButtonController('hide', 0);
        WheelConroller.rewardItemController('hide', 500);
        WheelConroller.playButtonController('show', 500);
    }

    showReward(item_id) {

        WheelConroller.reward_item_info = WheelConroller.getRewardItemInfo(item_id);

        if(WheelConroller.reward_item_info == null)
            return WheelConroller.debug('Невозможно отобразить анимацю, так как предмет с ID [' + item_id + '] не найден в списке.');

        WheelConroller.playButtonController('hide', 0);

        WheelConroller.processingController('show', 0);
        WheelConroller.processingController('hide', WheelConroller.animation_time * 1000);

        WheelConroller.rewardItemController('update_info', WheelConroller.animation_time * 1000);
        WheelConroller.rewardItemController('show', WheelConroller.animation_time * 1000);

        WheelConroller.rotateSectors(WheelConroller.reward_item_info.index);

        WheelConroller.updateButtonController('show', WheelConroller.animation_time * 1000);
    }

    static rotateSectors(item_index) {

        let item_list = WheelConroller.wheel_sectors.querySelectorAll('.wheel__sector');
        // Количество градусов на 1 сектор
        let step = 360 / item_list.length;
        // Прибавляем к началу сектора 1, чтобы маркер не мог указать на пересечение 2 секторов
        // Также прибавляем 720 градусов, чтобы колесо сделало + 2 полных оборота
        let start_deg = ( 360 - ( item_index * step ) ) + 90 + 1 + 720;
        // Отнимаем от конца сектора 1, чтобы маркер не мог указать на пересечение 2 секторов
        // Также прибавляем 720 градусов, чтобы колесо сделало + 2 полных оборота
        let end_deg = ( 360 - ( item_index * step ) ) + 90 + step - 1 + 720;

        WheelConroller.wheel_sectors.style.transition = 'transform ' + WheelConroller.animation_time + 's ease-in-out';
        WheelConroller.wheel_sectors.style.transform = 'rotate(' + WheelConroller.getRandomInt(start_deg, end_deg) + 'deg)';
    }

    // Получить рандомное число в интервале
    // Максимум не включается, минимум включается
    static getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min)) + min;
    }

    // Метод для получения сектора с определенным item_id
    static getRewardItemInfo(item_id) {
        let result = null;
        let item_list = WheelConroller.wheel_sectors.querySelectorAll('.wheel__sector');
        Array.prototype.forEach.call(item_list, function(sector, index) {
            if(sector.getAttribute('data-item-id') == item_id) {
                result = {
                    id: item_id,
                    name: sector.getAttribute('data-item-name'),
                    index: index + 1
                };
            }
        });
        return result;
    }

    // Метод для управления кнопкой "Start Game"
    static playButtonController(action, timeout) {

        switch (action) {
            case 'show':

                setTimeout(function () {
                    WheelConroller.play_button.classList.add('wheel-result__button--show');
                    WheelConroller.debug('playButtonController:' + action);
                }, timeout);
                break;

            case 'hide':

                setTimeout(function () {
                    WheelConroller.play_button.classList.remove('wheel-result__button--show');
                    WheelConroller.debug('playButtonController:' + action);
                }, timeout);
                break;

            default:
                WheelConroller.debug('playButtonController:' + action);
        }

    }

    // Метод для управления прогрессбаром
    static processingController(action, timeout) {
        switch (action) {
            case 'show':

                setTimeout(function () {
                    WheelConroller.processing_bar.style.width = '0px';
                    setTimeout(function () {
                        WheelConroller.processing_bar.style.transition = 'width ' + WheelConroller.animation_time + 's linear';
                        WheelConroller.processing_bar.style.width = '100%';
                        WheelConroller.processing_box.classList.add('wheel-result__processing--show');
                        WheelConroller.debug('processingController:' + action);
                    }, 100);
                }, timeout);
                break;

            case 'hide':

                setTimeout(function () {
                    WheelConroller.processing_bar.style.transition = 'width 0s linear';
                    WheelConroller.processing_box.classList.remove('wheel-result__processing--show');
                    WheelConroller.debug('processingController:' + action);
                }, timeout);
                break;

            default:
                WheelConroller.debug('processingController:' + action);
        }
    }

    // Метод для управления блоком с выйграшным предметом
    static rewardItemController(action, timeout) {
        switch (action) {
            case 'show':

                setTimeout(function () {
                    WheelConroller.reward_item_box.classList.add('wheel-result__reward--show');
                    $('#win-item').text(WheelConroller.reward_item_info.name);
                    $('#LuckyweelWin').addClass('show');
                    WheelConroller.debug('rewardItemController:' + action);
                }, timeout);
                break;

            case 'hide':

                setTimeout(function () {
                    WheelConroller.reward_item_box.classList.remove('wheel-result__reward--show');
                    WheelConroller.debug('rewardItemController:' + action);
                }, timeout);
                break;
            case 'update_info':

                setTimeout(function () {
                    WheelConroller.reward_item_box.querySelector(".wheel-result__reward-name").innerHTML = WheelConroller.reward_item_info.name;
                    WheelConroller.debug('rewardItemController:' + action);
                }, timeout);
                break;

            default:
                WheelConroller.debug('rewardItemController:' + action);
        }
    }

    // Метод для управления блоком с выйграшным предметом
    static updateButtonController(action, timeout) {
        switch (action) {
            case 'show':

                setTimeout(function () {
                    WheelConroller.update_button.classList.add('wheel__update--show');
                    WheelConroller.debug('updateButtonController:' + action);
                }, timeout);
                break;

            case 'hide':

                setTimeout(function () {
                    WheelConroller.update_button.classList.remove('wheel__update--show');
                    WheelConroller.debug('updateButtonController:' + action);
                }, timeout);
                break;

            default:
                WheelConroller.debug('updateButtonController:' + action);
        }
    }

    // Метод для обновления предметов в колесе
    static updateItems(items) {
        WheelConroller.wheel_sectors.style.transition = '1s';
        WheelConroller.wheel_sectors.style.transform = 'rotate(0deg)';

        setTimeout(function () {
            WheelConroller.wheel_sectors.innerHTML = WheelConroller.compileSectorsTemplate(items);
            WheelConroller.wheel.setAttribute('data-item-count', items.length);
        }, 500);

        WheelConroller.rewards_box.style.transition = 'opacity .5s';
        setTimeout(function () {
            WheelConroller.rewards_box.style.opacity = '0';
            setTimeout(function () {
                WheelConroller.rewards_box.innerHTML = WheelConroller.compileRewardsTemplate(items);
                WheelConroller.rewards_box.style.opacity = '1';
            }, 500);
        }, 100);
    }

    static compileSectorsTemplate(items) {
        let html = '';
        Array.prototype.forEach.call(items, function(item) {
            html += `
                <div class="wheel__sector" data-item-id="` + item.id + `" data-item-name="` + item.name + `">
                    <div class="wheel__item-icon"><img src="` + item.icon + `" alt=""></div>
                </div>
            `;
        });
        return html;
    }

    static compileRewardsTemplate(items) {
        let html = '';
        Array.prototype.forEach.call(items, function(item) {
            html += `
                <div class="item-list__item">
                    <div class="item-list__item-icon"><img src="` + item.icon + `" alt=""></div>
                    <div class="item-list__item-info">
                        <div class="item-list__item-name">` + item.name + `</div>
                        <div class="item-list__item-desc">Drop chance: <span>` + item.chance + `%</span></div>
                    </div>
                </div>
            `;
        });
        return html;
    }


    static debug(subject) {
        if(WheelConroller.debug_mod)
            console.log(subject);
    }
}

let wheel_controller = new WheelConroller();

let update_data = {
    "items": [
        {
            "id": 1,
            "chance": 10,
            "name": "Imperial Crusader Shield 1",
            "icon": "/wheel/icons/1.png",
        },
        {
            "id": 2,
            "chance": 10,
            "name": "Imperial Crusader Shield 2",
            "icon": "/wheel/icons/2.png",
        },
        {
            "id": 3,
            "chance": 10,
            "name": "Imperial Crusader Shield 3",
            "icon": "/wheel/icons/3.png",
        },
        {
            "id": 4,
            "chance": 10,
            "name": "Imperial Crusader Shield 4",
            "icon": "/wheel/icons/4.png",
        },
        {
            "id": 5,
            "chance": 10,
            "name": "Imperial Crusader Shield 5",
            "icon": "/wheel/icons/5.png",
        }
    ]
}

document.querySelector('#wheel-button').onclick = function (event) {
    event.preventDefault();

    var button = document.querySelector('#wheel-button');
    var dataValue = button.getAttribute('data-free');

    if (dataValue != 1) {

        button.setAttribute('data-free', '0');

        // Запрашиваем подтверждение от пользователя
        let alertTextElement = document.querySelector('#alert-text');
        let alertText = alertTextElement.textContent || alertTextElement.innerText;
        let confirmation = confirm(alertText);

        // Если пользователь нажал "Отмена", выходим из функции
        if (!confirmation) {
            return;
        }
    }

    fetch('/account/getRewardLuckyWheelItem', {
        method: 'GET',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
    })
        .then(response => {
            return response.json();
        })
        .then(data => {
            console.log(data);
            if (!isNaN(parseFloat(data)) && isFinite(data)) {
                wheel_controller.showReward(data);

                fetch('/account/getUserBalance', {
                    method: 'GET',
                    cache: 'no-cache',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                })
                    .then(response => {
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        $('.balance-cur .user-balance').text(data.balance);
                    })
                    .catch((error) => {
                        console.log(error)
                    });

            } else {
                alert(data);
            }
        })
        .catch((error) => {
            console.log(error)
        });



}

document.querySelector('#wheel-update').onclick = function(event) {
    event.preventDefault();

    fetch('/account/getLuckyWheelItems', {
        method: 'GET',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
    })
        .then(response => {
            return response.json();
        })
        .then(data => {
            console.log(data);
    	    wheel_controller.update(data);
    	    $('.free-spin').hide();
            $('.pay-spin').show();
        })
        .catch((error) => {
            console.log(error)
        });
}

