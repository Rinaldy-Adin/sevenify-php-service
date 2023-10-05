class Adios {
    makeRequest(url, method, data = null, contentType = null) {
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

            if (!data) {
                xhr.send();
            } else {
                if (contentType != 'multipart/form-data')
                    xhr.setRequestHeader('Content-type', contentType);
                if (contentType == 'multipart/form-data')
                    data = new FormData(data);
                xhr.send(data);
            }
        });
    }

    async get(url) {
        return await this.makeRequest(url, 'GET');
    }

    async post(url, data) {
        return await this.makeRequest(url, 'POST', data, 'application/x-www-form-urlencoded');
    }

    async postFormData(url, data) {
        return await this.makeRequest(url, 'POST', data, 'multipart/form-data');
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