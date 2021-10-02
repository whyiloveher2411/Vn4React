import React from 'react'

function View(props) {
    return (
        <>
            {props.content ? (new Date(props.content)).toLocaleString() : ''}
        </>
    )
}

export default View
