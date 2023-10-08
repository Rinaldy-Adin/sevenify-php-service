class Adios {
    makeRequest(url, method, data = null, contentType = null, blob = false, additionalData = []) {
        return new Promise(function (resolve, reject) {
            let xhr = new XMLHttpRequest();

            xhr.open(method, url);

            xhr.onload = function () {
                if (this.status >= 200 && this.status < 300) {
                    resolve(xhr.response);
                } else {
                    reject({
                        status: this.status,
                        statusText: xhr.statusText,
                        response: xhr.response
                    });
                }
            };

            xhr.onerror = function () {
                reject({
                    status: this.status,
                    statusText: xhr.statusText,
                    response: xhr.response
                });
            };

            if (blob) {
                xhr.responseType = 'blob';
            }

            if (!data) {
                xhr.send();
            } else {
                if (contentType != 'multipart/form-data')
                    xhr.setRequestHeader('Content-type', contentType);
                if (contentType == 'multipart/form-data') {
                    data = new FormData(data);
                    additionalData.forEach(({key, value}) => {
                        data.append(key, value)
                    });
                }
                xhr.send(data);
            }
        });
    }

    async get(url, params = {}, blob = false) {
        let paramStr = '';
        if (Object.keys(params).length !== 0) {
            paramStr = '?'
            for (const key in params) {
                if (paramStr.slice(-1) !== '?')
                    paramStr += '&';
                paramStr += `${key}=${params[key]}`;
            }
        }
        return await this.makeRequest(url + paramStr, 'GET', null, null, blob);
    }

    async post(url, data) {
        return await this.makeRequest(url, 'POST', data, 'application/x-www-form-urlencoded');
    }

    async delete(url) {
        return await this.makeRequest(url, 'DELETE');
    }

    async postFormData(url, element, additionalData = []) {
        return await this.makeRequest(url, 'POST', element, 'multipart/form-data', false, additionalData);
    }

    objectToXWWWFormUrlencoded(obj) {
        const params = [];

        for (const key in obj) {
            if (obj.hasOwnProperty(key)) {
                const encodedKey = encodeURIComponent(key);
                const encodedValue = encodeURIComponent(obj[key]);
                params.push(`${encodedKey}=${encodedValue}`);
            }
        }

        return params.join('&');
    }
}

function debounce(func, timeout = 300) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => { func.apply(this, args); }, timeout);
    };
}