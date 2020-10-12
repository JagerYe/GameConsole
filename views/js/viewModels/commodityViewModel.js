function getEmpUpdateCommodityItemView(comUse, id, name, price, quantity, status, creationDatetime, changeDatetime = '') {
        return `<td>${id}</td>
                <td><img src="/GameConsole/commodity/getOneImg?id=${id}" alt=""
                        id="showImg${id}"></td>
                <td>${name}</td>
                <td>${price}</td>
                <td>${quantity}</td>
                <td>${(status === '1') ? '上架' : '下架'}</td>
                <td>${creationDatetime}</td>
                <td>${changeDatetime}</td>
                ${getControl(comUse)}`;
}

function getEmpInsertCommodityItemView(comUse, id, name, price, quantity, status, creationDatetime, changeDatetime = '') {
        return `<tr id="com${id}">
                        <td>${id}</td>
                        <td><img src="/GameConsole/commodity/getOneImg?id=${id}" alt=""
                                id="showImg${id}"></td>
                        <td>${name}</td>
                        <td>${price}</td>
                        <td>${quantity}</td>
                        <td>${(status === '1') ? '上架' : '下架'}</td>
                        <td>${creationDatetime}</td>
                        <td>${changeDatetime}</td>
                        ${getControl(comUse)}
                </tr>`;
}

function getControl(comUse) {
        return (comUse) ? `<td><button class="btn btn-info width100Percentage updateBtn" type="button" data-toggle="modal"
        data-target="#commodityModal">修改</button></td>`: '';
}

function getCommodityItemView(id, name, price) {
        return `<div class="col-sm-6 col-md-4 col-lg-3 col-xs-12 oneCommodity">
                        <a href="/GameConsole/commodity/getOneView?id=${id}">
                        <table>
                                <tr><td colspan="2">${name}</td></tr>
                                <tr>
                                        <td colspan="2">
                                                <img src="/GameConsole/commodity/getOneImg?ID=${id}"
                                                onerror="javascript:this.src='/GameConsole/views/img/gravatar.jpg'">
                                        </td>
                                </tr>
                                <tr><td>價格：${price}</td></tr>
                        </table>
                        </a>
                </div>`;
}

function getShoppingCartItemView(id, name, price, maxQuantity, quantity) {
        return `<div class="row oneItem width100Percentage" id="oneItem${id}">
                        <div class="col-xs-3">
                        <img src="/GameConsole/commodity/getOneImg?ID=${id}"
                                onerror="javascript:this.src='/GameConsole/views/img/gravatar.jpg'">
                        </div>
                        <div class="col-xs-2 itemText">${name}</div>
                        <div class="col-xs-2 itemText">${price}</div>
                        <div class="col-xs-3 ">${getQuantityInputView(maxQuantity, quantity)}</div>
                        <div class="col-xs-2">
                        <button class="width100Percentage deleteBtn" id="deleteBtn${id}">刪除</button>
                        </div>
                </div>`;
}

function getQuantityInputView(maxQuantity, quantity) {
        return (maxQuantity <= 0) ?
                `<h3>此商品已售完</h3>` :
                `<input type="number" class="width100Percentage quantity form-control" id="buyQuantity${id}" max="${maxQuantity}" min="1" value="${quantity}">`;
}