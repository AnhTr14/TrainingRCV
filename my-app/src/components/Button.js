import React from "react";

const Button = (props) => {
    return (
            <button
                type={props.type}
                className={`btn btn-${props.color} btn-sm`}
                onClick={props.onClick}
                data-id={props.id}
            >
                {props.text}
                <i className={`fas fa-${props.icon}`}></i>
            </button>
        
    );
};

export default Button;
