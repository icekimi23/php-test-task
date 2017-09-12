var body = document.body;
var url = location.origin;

var bucket = body.querySelector('#bucket');
var productList = body.querySelector('#productList');

countSummary();

body.addEventListener('click', onAddToBucketClick);
body.addEventListener('click', onRemoveFromBucketClick);

body.addEventListener('change', onAmountChange);

function onAmountChange(event) {

    var target = event.target;

    if (!target.classList.contains('amount')) return;

    var bucket = target.closest('#bucket');

    if (!bucket) return;

    var liElem = target.closest('.inner-wrapper');

    var id = liElem.querySelector('.id').value;
    var amount = liElem.querySelector('.amount').value || 1;

    var queryString = 'id=' + id + '&amount=' + amount;

    $.ajax({
        url: url + '/updateAmount.php',
        method: 'POST',
        data: queryString,
        success: function (res) {
            countSummary();
        }
    });

}

function onAddToBucketClick(event) {

    var target = event.target;

    if (!target.classList.contains('addToBucket')) return;

    event.preventDefault();

    var liElem = target.closest('.inner-wrapper');

    var id = liElem.querySelector('.id').value;
    var amount = liElem.querySelector('.amount').value || 1;

    var queryString = 'id=' + id + '&amount=' + amount;

    $.ajax({
        url: url + '/addToBucket.php',
        method: 'POST',
        data: queryString,
        success: function (res) {
            moveToBucket(liElem);
            countSummary();
        }
    });

}

function onRemoveFromBucketClick(event) {

    var target = event.target;

    event.preventDefault();

    if (!target.classList.contains('removeFromBucket')) return;

    var liElem = target.closest('.inner-wrapper');

    var id = liElem.querySelector('.id').value;

    var queryString = 'id=' + id;

    $.ajax({
        url: url + '/removeFromBucket.php',
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
    var btn = elem.querySelector('.addToBucket');
    btn.innerHTML = 'Удалить';
    btn.className = 'removeFromBucket';

    var amount = elem.querySelector('.amount');
    if (!parseInt(amount.value)){
        amount.value = 1;
    }

}

function moveFromBucket(elem) {
    productList.appendChild(elem);
    var btn = elem.querySelector('.removeFromBucket');
    btn.innerHTML = 'В корзину';
    btn.className = 'addToBucket';

    var amount = elem.querySelector('.amount');
    amount.value = 1;

}

function countSummary() {
    var summary = 0;

    var elems = bucket.querySelectorAll('.inner-wrapper');

    [].forEach.call(elems, function (elem) {
        var price = parseFloat(elem.querySelector('.price-inner').innerHTML) || 0;
        var amount = parseInt(elem.querySelector('.amount').value) || 0;
        summary += price * amount;
    });

    var cart = document.querySelector('.cart');
    var summaryText = cart.querySelector('.summary-text');
    summaryText.innerHTML = 'ИТОГО: ' + summary + ' руб.';

}