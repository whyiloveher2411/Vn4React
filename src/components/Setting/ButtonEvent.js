import { Button } from '@material-ui/core'
import React from 'react'
import { useAjax } from 'utils/useAjax';
import CircularProgress from '@material-ui/core/CircularProgress';

function ButtonEvent(props) {

    const { ajax, Loading, open } = useAjax();

    const handleOnclick = () => {
        if (!open) {
            ajax({
                ...props.params
            });
        }
    };

    return (
        <>
            <Button
                size="small"
                onClick={handleOnclick}
                endIcon={open ? <CircularProgress size={18} color={'inherit'} /> : null}
                color={props.color ?? 'primary'}>
                {props.label}
            </Button>
        </>
    )
}

export default ButtonEvent
