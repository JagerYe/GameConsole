function getEmpUpdateCommodityItemView(id, name, price, quantity, status, creationDatetime, changeDatetime = '') {
        return `<td>${id}</td>
                <td><img src="/GameConsole/commodity/getOneImg?id=${id}" alt=""
                        id="showImg${id}"></td>
                <td>${name}</td>
                <td>${price}</td>
                <td>${quantity}</td>
                <td>${(status === '1') ? '上架' : '下架'}</td>
                <td>${creationDatetime}</td>
                <td>${changeDatetime}</td>
                <td>
                        <button class="btn btn-info width100Percentage updateBtn" type="button" data-toggle="modal"
                        data-target="#commodityModal">修改</button>
                </td>`;
}

function getEmpInsertCommodityItemView(id, name, price, quantity, status, creationDatetime, changeDatetime = '') {
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
                        <td>
                                <button class="btn btn-info width100Percentage updateBtn" type="button" data-toggle="modal"
                                data-target="#commodityModal">修改</button>
                        </td>
                </tr>`;
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