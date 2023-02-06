import {useState, useEffect} from "react";
import {useParams} from "react-router-dom";
import {getUser} from "/api/Users";
import {errorLog} from "/log/Log";
import {objectToString} from "/tools/arrTools";

const LIST_OF_USER_PROPS = ['name', 'username', 'email', 'phone', 'website', "address", "company"];

export default function User() {
    const {id} = useParams();
    const [user, setUser] = useState(null);
    const [serverErr, setServerErr] = useState(null);

    useEffect(() => {
        const callApiUser = () => {
            getUser(id)
                .then((response) => {
                    const users = response.data.data.users;
                    setUser(users);
                })
                .catch((error) => {
                    errorLog(error);
                    setServerErr("Sorry, the server currently has a technical issue, please, come back later.");
                })
        };

        if (!user) {
            callApiUser();
        }
    }, [user]);

    return (<table className={"suTable"}>
        {user ? LIST_OF_USER_PROPS.map(prop => {
            let propVal = user[prop];

            switch (prop) {
                case "address":
                case "company":
                    propVal = (<pre>{objectToString(": ", "\n", propVal)}</pre>);
                    break;
                case "website":
                    propVal = (<a href={propVal.match(/^http/) ? propVal : "https://" + propVal} target="_blank">{propVal}</a>);
                    break;
                case "phone":
                    propVal = (<a href={"tel:+" + propVal.split(" ")[0].replace(/[^\d]/g, "")}>{propVal}</a>);
                    break;
                case "email":
                    propVal = (<a href={`mailto:${propVal}`}>{propVal}</a>);
                    break;
            }

            return (
            <tr className={"suTable__row"}>
                <td className={"suTable__cell suTable__cellLabel"}>{prop}: </td>
                <td className={`suTable__cell suTable__cell${prop}`}>{propVal}</td>
            </tr>)})
            : (serverErr ? serverErr : "...loading")
        }
    </table>)
}
