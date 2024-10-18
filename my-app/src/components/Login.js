import React, { useState } from "react";
import axios from "axios";
import { accessToken, setToken, getToken } from "../helpers/localStorage";
import Button from "./Button";
import InputField from "./InputField";
import { useNavigate } from "react-router-dom";
import { apiLogin, login } from "../helpers/apiRoute";

const Login = () => {
    const [inputs, setInputs] = useState({
        email: "",
        password: "",
    });

    const [errors, setErrors] = useState({
        email: "",
        password: "",
        general: "",
    });

    const navigate = useNavigate();

    const handleClick = (event) => {
        event.preventDefault();
        axios
            .post(apiLogin, { ...inputs })
            .then((res) => {
                if (res.status === 200) {
                    setToken(accessToken, res.data.access_token);
                    navigate("/user");
                } else {
                    alert('Thông tin đăng nhập sai');
                }
            }).catch(error => {
                console.log(error);
                if (error.response && error.response.status === 422) {
                    setErrors({
                        email: error.response.data.errors.email ? error.response.data.errors.email[0] : "",
                        password: error.response.data.errors.password ? error.response.data.errors.password[0] : "",
                        general: "",
                    });
                } else if (error.response && error.response.status === 401) {                    
                    setErrors({
                        email: "",
                        password: "",
                        general: "Thông tin đăng nhập sai",
                    });
                } else {
                    setErrors({
                        email: "",
                        password: "",
                        general: "Lỗi",
                    });
                }
            });
    };

    const handleChange = (event) => {
        const name = event.target.name;
        const value = event.target.value;
        setInputs({ ...inputs, [name]: value });
    };

    return (
        <div className="login-page">
            <div className="card-primary" style={{ width: "30%" }}>
                <div className="card-header">
                    <h3 className="card-title">Đăng nhập</h3>
                </div>
                <div className="login-card-body">
                    <InputField
                        id="email"
                        name="email"
                        type="text"
                        text="Email"
                        value={inputs.email}
                        onChange={handleChange}
                        className="form-control"
                        error = {errors.email}
                    />
                    <InputField
                        id="password"
                        name="password"
                        type="password"
                        text="Password"
                        value={inputs.password}
                        onChange={handleChange}
                        className="form-control"
                        error = {errors.password}
                    />
                    {errors.general && <div className="text-danger">{errors.general}</div>}
                    <Button
                        type="button"
                        text="Login"
                        onClick={handleClick}
                        color="primary"
                        className="btn-block"
                    />
                </div>
            </div>
        </div>
    );
};

export default Login;
