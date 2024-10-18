export const accessToken = 'access_token';

export const setToken = (key, value) => {
    localStorage.setItem(key, value);
};

export const getToken = (key) => {
    return localStorage.getItem(key);
}

export const removeToken = (key) => {
    return localStorage.removeItem(key);
}

