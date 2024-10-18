import logo from "./logo.svg";
import "./App.css";
import Login from "./components/Login";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import User from "./components/User";
import ProtectedRoute from "./helpers/ProtectedRoute";
import PublicRoute from "./helpers/PublicRoute";
import Users from "./components/Users";

function App() {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/login" element={<PublicRoute component={<Login/>} />} />
                <Route path="/user"  element={<ProtectedRoute component={<User />} />} />
                <Route path="/users"  element={<ProtectedRoute component={<Users />} />} />
            </Routes>
        </BrowserRouter>
    );
}

export default App;
