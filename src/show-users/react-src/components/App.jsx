import React from "react";
import { Route, Routes, BrowserRouter } from "react-router-dom";
import "/scss/main.scss";
import Layout from "./Layout";
import UsersList from "./UsersList";
import User from "./User";

export default function App() {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/show-users" element={<Layout />}>
                    <Route index element={<UsersList />} />
                    <Route path="/show-users/:id" element={<User />} />
                </Route>
            </Routes>
        </BrowserRouter>
    )
}
