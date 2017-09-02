let body = document.body;

let bucket = body.querySelector('#bucket');
let productList = body.querySelector('#productList');

countSummary();

body.addEventListener('click', onAddToBucketClick);
body.addEventListener('click', onRemoveFromBucketClick);

body.addEventListener('change', onAmountChange);

function onAmountChange(event) {

    let target = event.target;

    if (!target.classList.contains('amount')) return;

    let bucket = target.closest('#bucket');

    if (!bucket) return;

    let liElem = target.closest('.inner-wrapper');

    let id = liElem.querySelector('.id').value;
    let amount = liElem.querySelector('.amount').value || 1;

    let queryString = 'id=' + id + '&amount=' + amount;

    $.ajax({
        url: 'http://test-task.ru/updateAmount.php',
        method: 'POST',
        data: queryString,
        success: function (res) {
            countSummary();
        }
    });

}

function onAddToBucketClick(event) {

    let target = event.target;

    if (!target.classList.contains('addToBucket')) return;

    event.preventDefault();

    let liElem = target.closest('.inner-wrapper');

    let id = liElem.querySelector('.id').value;
    let amount = liElem.querySelector('.amount').value || 1;

    let queryString = 'id=' + id + '&amount=' + amount;

    $.ajax({
        url: 'http://test-task.ru/addToBucket.php',
        method: 'POST',
        data: queryString,
        success: function (res) {
            moveToBucket(liElem);
            countSummary();
        }
    });

}

function onRemoveFromBucketClick(event) {

    let target = event.target;

    event.preventDefault();

    if (!target.classList.contains('removeFromBucket')) return;

    let liElem = target.closest('.inner-wrapper');

    let id = liElem.querySelector('.id').value;

    let queryString = 'id=' + id;

    $.ajax({
        url: 'http://test-task.ru/removeFromBucket.php',
        method: 'POST',
        data: queryString,
        success: function (res) {
            moveFromBucket(liElem);
            countSummary();
        }
    });


}

function moveToBucket(elem) {
    bucket.appendChild(elem);
    let btn = elem.querySelector('.addToBucket');
    btn.innerHTML = 'Удалить';
    btn.className = 'removeFromBucket';

    let amount = elem.querySelector('.amount');
    if (!parseInt(amount.value)){
        amount.value = 1;
    }

}

function moveFromBucket(elem) {
    productList.appendChild(elem);
    let btn = elem.querySelector('.removeFromBucket');
    btn.innerHTML = 'В корзину';
    btn.className = 'addToBucket';

    let amount = elem.querySelector('.amount');
    amount.value = 1;

}

function countSummary() {
    let summary = 0;

    let elems = bucket.querySelectorAll('.inner-wrapper');

    [].forEach.call(elems, function (elem) {
        let price = parseFloat(elem.querySelector('.price').innerHTML) || 0;
        let amount = parseInt(elem.querySelector('.amount').value) || 0;
        summary += price * amount;
    });

    let cart = document.querySelector('.cart');
    let summaryText = cart.querySelector('.summary-text');
    summaryText.innerHTML = 'ИТОГО: ' + summary + ' руб.';

}