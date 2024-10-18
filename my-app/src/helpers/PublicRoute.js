import React from 'react';
import { getToken, accessToken } from './localStorage';
import { Navigate } from 'react-router-dom';

function PublicRoute({ component: Component, ...rest }) {
    const isAuthenticated = getToken(accessToken);
    return isAuthenticated ? <Navigate to="/user" /> : Component;
}
export default PublicRoute;