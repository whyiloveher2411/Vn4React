import Label from '../../Label'
import React from 'react'

function View(props) {

    if (props.content) {
        return (
            <>
                <Label
                    color={props.config.list_option[props.content]?.color ?? '#dedede'}
                    textColor={props.config.list_option[props.content]?.textColor} >
                    {props.config.list_option[props.content]?.title ?? props.content}
                </Label>
            </>
        )
    }
    return null;
}

export default View
