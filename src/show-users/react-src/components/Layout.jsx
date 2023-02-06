import {Outlet, Link, useLocation} from "react-router-dom";

export default function Layout() {
    const {pathname} = useLocation();

    return (
        <>
            {pathname !== "/show-users" ? <Link to={"/show-users"} className={"su_menu_link"}>« users list</Link> : ""}
            <Outlet />
        </>
    )
};
