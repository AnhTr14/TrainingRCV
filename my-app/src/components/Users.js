import axios from "axios";
import React, { useState, useEffect } from "react";
import DataTable from "react-data-table-component";
import { apiUsers, apiRoles } from "../helpers/apiRoute";
import Button from "./Button";
import { accessToken, getToken } from "../helpers/localStorage";

const Users = () => {
    const [data, setData] = useState([]);
    const [roles, setRoles] = useState([]);
    const [selectedUser, setSelectedUser] = useState(null);
    const [isModalOpen, setIsModalOpen] = useState(false);

    useEffect(() => {
        axios
            .post(
                apiUsers,
                {},
                {
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: "Bearer " + getToken(accessToken),
                    },
                }
            )
            .then((res) => {
                if (res.status === 200) {
                    setData(res.data);
                }
            });

        axios
            .post(
                apiRoles,
                {},
                {
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: "Bearer " + getToken(accessToken),
                    },
                }
            )
            .then((res) => {
                if (res.status === 200) {
                    setRoles(res.data);
                }
            });
    }, []);

    const handleNameClick = (name) => {
        alert(`Name: ${name}`);
    };

    const handleEditClick = (user) => {
        setSelectedUser(user);
        setIsModalOpen(true);
    };

    const handleModalClose = () => {
        setIsModalOpen(false);
        setSelectedUser(null);
    };

    const handleSaveChanges = () => {
        setIsModalOpen(false);
    };

    const columns = [
        {
            name: "Name",
            cell: (row) => (
                <span
                    onClick={() => handleNameClick(row.name)}
                    style={{ cursor: "pointer" }}
                >
                    {row.name}
                </span>
            ),
        },
        {
            name: "Email",
            selector: (row) => row.email,
            sortable: true,
        },
        {
            name: "Role",
            selector: (row) => row.role,
            sortable: true,
        },
        {
            name: "Status",
            selector: (row) => (row.is_active ? "Active" : "Inactive"),
            conditionalCellStyles: [
                {
                    when: (row) => row.is_active === 1,
                    style: { color: "green" },
                },
                {
                    when: (row) => row.is_active === 0,
                    style: { color: "red" },
                },
            ],
        },
        {
            name: "Action",
            cell: (row) => (
                <div style={{ display: "flex", gap: "3px" }}>
                    <Button
                        type="button"
                        color="info"
                        className="btn-block"
                        icon="pencil-alt"
                        onClick={() => {
                            console.log(row);
                            handleEditClick(row);
                        }}
                    />
                    <Button
                        type="button"
                        color="danger"
                        className="btn-block"
                        icon="trash"
                    />
                </div>
            ),
            ignoreRowClick: true,
            allowOverflow: true,
            button: true,
        },
    ];

    return (
        <>
            <DataTable columns={columns} data={data} pagination />
            {isModalOpen && selectedUser && (
                <div
                    className="modal fade show"
                    style={{ display: "block" }}
                    role="dialog"
                >
                    <div className="modal-dialog">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title">Edit User</h5>
                                <button
                                    type="button"
                                    className="close"
                                    onClick={handleModalClose}
                                >
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div className="modal-body">
                                <form>
                                    <div className="form-group">
                                        <label htmlFor="name">Name:</label>
                                        <input
                                            type="text"
                                            id="name"
                                            className="form-control"
                                            value={selectedUser.name}
                                            onChange={(e) =>
                                                setSelectedUser({
                                                    ...selectedUser,
                                                    name: e.target.value,
                                                })
                                            }
                                        />
                                    </div>
                                    <div className="form-group">
                                        <label htmlFor="role">Role:</label>
                                        <select
                                            id="role"
                                            className="form-control"
                                            value={selectedUser.role}
                                            onChange={(e) =>
                                                setSelectedUser({
                                                    ...selectedUser,
                                                    role: e.target.value,
                                                })
                                            }
                                        >
                                            {roles.map((role) => (
                                                <option
                                                    key={role.id}
                                                    value={role.name}
                                                >
                                                    {role.name}
                                                </option>
                                            ))}
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div className="modal-footer">
                                <button
                                    type="button"
                                    className="btn btn-secondary"
                                    onClick={handleModalClose}
                                >
                                    Close
                                </button>
                                <button
                                    type="button"
                                    className="btn btn-primary"
                                    onClick={handleSaveChanges}
                                >
                                    Save changes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </>
    );
};

export default Users;
