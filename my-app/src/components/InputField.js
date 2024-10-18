import React from "react";

const InputField = (props) => {
    return (
        <div className="form-group">
            <label htmlFor={props.id}>{props.text}</label>
            <input
                id={props.id}
                name={props.name}
                type={props.type}
                value={props.value}
                onChange={props.onChange}
                placeholder={props.text}
                className="form-control"
            />
            {props.error && <div className="text-danger">{props.error}</div>}
        </div>
    );
};

export default InputField;
