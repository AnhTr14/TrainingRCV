import axios from "axios";
import React, { useEffect, useState } from "react";
import { accessToken, getToken, removeToken } from "../helpers/localStorage";
import Button from "./Button";
import { useNavigate } from "react-router-dom";
import { apiLogout, apiUser } from "../helpers/apiRoute";



const User = () => {
    const [userData, setUserData] = useState({
        id: "",
        email: "",
        name: "",
        created_at: "",
    });
    const navigate = useNavigate();

const handleClick = (event) => {
    event.preventDefault();
    axios.post(
        apiLogout,
        {},
        {
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + getToken(accessToken),
            },
        }
    )
    .then (res => {
        removeToken(accessToken);
        navigate("/login");
    })
};

    useEffect(() => {
        axios
            .post(
                apiUser,
                {},
                {
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: "Bearer " + getToken(accessToken),
                    },
                }
            )
            .then((res) => {
                setUserData(res.data.user);
            });
    }, []);

    return (
        <div>
            <p>{userData.id}</p>
            <p>{userData.email}</p>
            <p>{userData.name}</p>
            <p>{userData.created_at}</p>
            <Button
                type="button"
                text="Logout"
                onClick={handleClick}
                color="primary"
                className="btn-block"
            ></Button>
        </div>
        
    );
};

export default User;
