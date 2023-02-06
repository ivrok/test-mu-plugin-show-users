const getCurrentTime = () => Date.now() / 1000;

const getCache = key => {
    const jsonData = localStorage.getItem(key);
    if (!jsonData) {
        return false;
    }

    const data = JSON.parse(jsonData);

    if (data.time < getCurrentTime()) {
        localStorage.removeItem(key);
        return false;
    }

    return data.data;
};

const setCache = (key, cacheTime, data) => localStorage.setItem(key, JSON.stringify({time: getCurrentTime() + cacheTime, data: data}));

export {getCache, setCache};
