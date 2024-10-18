import React from "react";
import { accessToken, getToken } from "./localStorage";
import { Navigate, Route } from "react-router-dom";

function ProtectedRoute({ component: Component, ...rest }) {
    const isAuthenticated = getToken(accessToken);
    return isAuthenticated ? Component : <Navigate to="/login" />;
}

export default ProtectedRoute;
