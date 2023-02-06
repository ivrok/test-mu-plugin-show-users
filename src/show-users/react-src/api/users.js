import axios from "axios";

function getList() {
    return axios.get("/wp-json/show-users/v1/getAll");
}

function getUser(id) {
    return axios.get("/wp-json/show-users/v1/get/" + id);
}

export {getList, getUser};
