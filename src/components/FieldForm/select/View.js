import Label from '../../Label'
import React from 'react'

function View(props) {

    if (props.content) {

        if (props.config.template === 'dotcolor') {
            return (
                <>
                    <span style={{ marginBottom: 2, display: 'inline-block', width: 6, height: 6, borderRadius: '50%', backgroundColor: props.config.list_option[props.content]?.color ?? '#dedede' }}></span>&nbsp;&nbsp;{props.config.list_option[props.content]?.title ?? props.content}
                </>
            )
        } else if (props.config.template === 'textcolor') {
            return <strong style={{ color: props.config.list_option[props.content]?.color ?? 'unset' }}>{props.config.list_option[props.content]?.title ?? props.content}</strong>
        }

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
