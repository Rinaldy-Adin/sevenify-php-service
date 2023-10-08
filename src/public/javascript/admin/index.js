// import '../adios';

let currentPage = 1;
let pageCount = 1;



async function loadDataPage(url, page, updateDataListCb) {
    const adios = new Adios();

    try {
        const params = [];
        params['page'] = page;

        const resp = await adios.get(url, params);
        const data = JSON.parse(resp);
        const result = data.data.result;
        pageCount = data.data['page-count'];
        currentPage = page;

        updateDataListCb(adios, result);
        updatePagination(pageCount);
    } catch (error) {
        if (error.response) {
            const data = JSON.parse(error.response);
            alert(data.message);
        } else {
            console.error(error);
        }
    }
}

function updatePagination(pageCount) {
    let startNum = Math.max(currentPage - 1, 1);
    let endNum = Math.min(currentPage + 1, pageCount);

    if (currentPage == 1)
        endNum = Math.min(currentPage + 2, pageCount)

    if (currentPage == pageCount)
        startNum = Math.max(currentPage - 2, 1);

    const elements = ['<img onclick="changePage(1)" src="/public/assets/icons/double-left.svg" id="pagination-first" class="clickable">'];
    for (let i = startNum - 1; i < endNum; i++) {
        if (i + 1 == currentPage) {
            elements.push(`<div class="pagination-item clickable pagination-active">${i + 1}</div>`);
        } else {
            elements.push(`<div onclick="changePage(${i + 1})" class="pagination-item clickable">${i + 1}</div>`);
        }
    }
    elements.push('<img onclick="changePage(pageCount)" src="/public/assets/icons/double-right.svg" id="pagination-last" class="clickable">');

    document.getElementById('pagination').innerHTML = elements.join(' ');
}