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