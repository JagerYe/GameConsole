function getEmployeeListView(empUse,id, account, name, email, creationDatetime, changeDatetime = '') {
    return `<tr id="emp${id}">
                <td>${id}</td>
                <td>${account}</td>
                <td>${name}</td>
                <td>${email}</td>
                <td>${creationDatetime}</td>
                <td>${changeDatetime}</td>
                <td>
                    <button class="btn btn-info width100Percentage updatePermissionBtn" type="button" data-toggle="modal" data-target="#updatePermissionModal">
                        ${empUse?'修改':'檢視'}權限
                    </button>
                </td>
            </tr>`;
}