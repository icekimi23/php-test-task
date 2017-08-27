let body = document.body;

let bucket = body.querySelector('#bucket');
let productList = body.querySelector('#productList');

body.addEventListener('click', onAddToBucketClick);
body.addEventListener('click', onRemoveFromBucketClick);

body.addEventListener('change', onAmountChange);

function onAmountChange(event) {

    let target = event.target;

    if (!target.classList.contains('amount')) return;

    let bucket = target.closest('#bucket');

    if (!bucket) return;

    let liElem = target.closest('li');

    let id = liElem.querySelector('.id').value;
    let amount = liElem.querySelector('.amount').value || 1;

    let queryString = 'id=' + id + '&amount=' + amount;

    $.ajax({
        url : 'http://test-task.ru/updateAmount.php',
        method: 'POST',
        data : queryString,
        success : function(res){
            debugger;
        }
    });

}

function onAddToBucketClick(event) {

    let target = event.target;

    if (!target.classList.contains('addToBucket')) return;

    let liElem = target.closest('li');

    let id = liElem.querySelector('.id').value;
    let amount = liElem.querySelector('.amount').value || 1;

    // let data = {
    //     id : id,
    //     amount : amount
    // };

    let queryString = 'id=' + id + '&amount=' + amount;

    $.ajax({
        url : 'http://test-task.ru/addToBucket.php',
        method: 'POST',
        data : queryString,
        success : function(res){
            debugger;
            moveToBucket(liElem);
        }
    });

}

function onRemoveFromBucketClick(event){

    let target = event.target;

    if (!target.classList.contains('removeFromBucket')) return;

    let liElem = target.closest('li');

    let id = liElem.querySelector('.id').value;

    let queryString = 'id=' + id;

    $.ajax({
        url : 'http://test-task.ru/removeFromBucket.php',
        method: 'POST',
        data : queryString,
        success : function(res){
            debugger;
            moveFromBucket(liElem);
        }
    });


}

function moveToBucket(elem){
    bucket.appendChild(elem);
    let btn = elem.querySelector('.addToBucket');
    btn.innerHTML = 'Удалить';
    btn.className = 'removeFromBucket';

}

function moveFromBucket(elem){
    productList.appendChild(elem);
    let btn = elem.querySelector('.removeFromBucket');
    btn.innerHTML = 'Добавить в корзину';
    btn.className = 'addToBucket';
}