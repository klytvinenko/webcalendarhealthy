class API {
    static get(url) {
        return new Promise((resolve, reject) => {
            fetch(url, {
                method: 'GET',
            })
                .then((response) => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        // Важливо: відхиляємо Promise, якщо HTTP статус не успішний
                        throw new Error(`HTTP Error: ${response.status} for ${url}`);
                    }
                })
                .then((result) => {
                    if (result.status == 1) {
                        let res = result.res !== undefined ? result.res : result.data;
                        resolve(res); // Вирішуємо Promise з отриманими даними
                    } else {
                        // Важливо: відхиляємо Promise, якщо API повернуло status != 1
                        const errorMessage = result.error || "Невідома помилка API";
                        console.error(`При читанні даних з API виникла помилка! З url ${url} - ${errorMessage}`);
                        reject(new Error(`API Error: ${errorMessage}`)); // Відхиляємо Promise
                    }
                })
                .catch((error) => {
                    // Перехоплюємо всі інші помилки (мережі, парсингу JSON тощо)
                    console.error(`Workspace або JSON парсинг помилка для ${url}:`, error);
                    reject(error); // Відхиляємо Promise
                });
        });
    }

    static post(url, body) {
        var promise = new Promise((resolve, reject) => {
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',

                },
                body: JSON.stringify(body)
            }).then((response) => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error(`Error: ${response.status}`);
                }
            }).then((result) => {
                if (result.status == 1) {
                    let res = result.res != undefined ? result.res : result.data;
                    resolve(res);
                }
                else console.error("При читанні даних з API виникла помилка!", "З url " + url + " - " + result.error);
            }).catch((error) => reject(error));
        });

        return promise;
    }

}