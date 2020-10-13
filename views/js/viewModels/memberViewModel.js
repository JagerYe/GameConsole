function getMemberListView(memUse, id, account, name, email, phone, status, creationDatetime, changeDatetime = '') {
    return `<tr class="oneMember">
                <td class="memberID">${id}</td>
                <td>${account}</td>
                <td>${name}</td>
                <td>${email}</td>
                <td>${phone}</td>
                <td>${getStatusBtnView(status)}</td>
                <td>${creationDatetime}</td>
                <td>${changeDatetime}</td>
                ${getShowOrderView(memUse)}
            </tr>
            <tr class="hidden memberOrders info">
                <td></td>
                <td class="showOrder" colspan="8"></td>
            </tr>`;
}

function getStatusBtnView(status) {
    if (status) {
        return `<button type="button" class="status width100 btn btn-success">啟用</button>`;
    } else {
        return `<button type="button" class="status width100 btn btn-danger">停用</button>`;
    }
}

function getShowOrderView(memUse) {
    if (memUse) {
        return `<td>
                    <button type="button" class="btn btn-info width100 orderListBtn">開啟訂單記錄</button>
                </td>`;
    }
}