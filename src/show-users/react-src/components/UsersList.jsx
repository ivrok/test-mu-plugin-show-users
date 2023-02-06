import {useState, useEffect} from "react";
import {Link} from "react-router-dom";
import {getList} from "/api/Users";
import {getCache, setCache} from "/cache/cache";
import {errorLog} from "/log/Log";

const CACHE_USERS_KEY = "users";
const CACHE_TIME = 10;//10 seconds

export default function UsersList() {
    const [users, setUsers] = useState(null);
    const [serverErr, setServerErr] = useState(null);

    useEffect(() => {
        const getUsers = () => {
            const cachedData = getCache(CACHE_USERS_KEY);

            if (cachedData) {
                setUsers(cachedData);
                return;
            }

            getList()
                .then((response) => {
                    const users = response.data.data.users;
                    setCache(CACHE_USERS_KEY, CACHE_TIME, users);
                    setUsers(users);
                })
                .catch((error) => {
                    errorLog(error);
                    setServerErr("Sorry, the server currently has a technical issue, please, come back later.");
                })
        };

        if (!users) {
            getUsers();
        }
    }, [users]);

    return (<table className={"suTable"}>{users ? users.map(user => (<tr className={"suTable__row"}>
        <td className={"suTable__cell suTable__cellID"}>{user.id}</td>
        <td className={"suTable__cell suTable__cellName"}>{user.name}</td>
        <td className={"suTable__cell suTable__cellUsername"}>{user.username}</td>
        <td className={"suTable__cell suTable__cellLink"}>
            <Link to={"/show-users/" + user.id}>details</Link>
        </td>
    </tr>)) : (serverErr ? serverErr : "...loading") }</table>)
}
