function getOrderListView(id, dateTime, total) {
    return `<div class="oneOrder" id="order1">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <td>訂單編號</td>
                            <td>日期</td>
                            <td>總價</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="orderID">${id}</td>
                            <td>${dateTime}</td>
                            <td>${total}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-xs-1"><button class="btn btn-info showDetailsBtn" type="button">查看明細</button></div>
                    <div class="col-xs-11">
                        <table class="table table-hover table-bordered">
                        <thead>
                                <tr>
                                    <td>商品名稱</td>
                                    <td>購買數量</td>
                                    <td>當時購買價格</td>
                                </tr>
                            </thead>
                            <tbody id="showDetails${id}">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>`;
}

function getDetailsListView(name, quantity, price) {
    return `<tr>
                <td>${name}</td>
                <td>${quantity}</td>
                <td>${price}</td>
            </tr>`;
}