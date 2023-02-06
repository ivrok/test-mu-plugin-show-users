function objectToString(sepKeyVal, sepItems, object) {
    let dataToStr = [];

    for (let key in object) {
        if (object.hasOwnProperty(key)) {
            dataToStr.push(typeof object[key] === 'object' ? key + sepKeyVal + objectToString(sepKeyVal, sepItems, object[key]) : key + sepKeyVal + object[key]);
        }
    }

    return dataToStr.join(sepItems);
}

export {objectToString};
