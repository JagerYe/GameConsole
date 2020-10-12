function getOrderListView(id, dateTime, total) {
    return `<div class="oneOrder">
                <div class="bg-info text-white">
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
                    <div class="row" id="details">
                        <div class="col-xs-12"><button class="btn btn-info showDetailsBtn" type="button">查看明細</button>
                        </div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-10" id="details${id}">
                            <table class="table table-hover">
                                <tbody id="showDetails${id}"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>`;
}

function getDetailsFieldView() {
    return `<tr>
                <td>
                    <button class="btn btn-light showMoreDetailsBtn">顯示更多</button>
                </td>
            </tr>`;
}

function getDetailsListView(name, quantity, price) {
    return `<tr>
                <td>${name}</td>
                <td>${quantity}</td>
                <td>${price}</td>
            </tr>`;
}