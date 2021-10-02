import { IconButton, InputAdornment } from '@material-ui/core';
import { FieldForm, MaterialIcon } from 'components';
import React from 'react';
import { uuid } from 'utils/helper';

function Code(props) {

    const [value, setValue] = React.useState({ [props.name]: props.post[props.name] ?? '' });

    React.useEffect(() => {
        props.onReview(value[props.name], props.name);
    }, [value]);

    React.useEffect(() => {
        setValue({ [props.name]: props.post[props.name] ?? '' });
    }, [props.post.id]);

    React.useEffect(() => {

        if (!props.post[props.name]) {
            let code = uuid(props.config.formatCode).toUpperCase();
            props.onReview(code, props.name);
            setValue({ ...value, [props.name]: code });
        }

    }, [props.post.id]);

    return (
        <FieldForm
            compoment='text'
            config={{
                title: 'Code',
            }}
            endAdornment={
                <InputAdornment position="end">
                    <IconButton
                        aria-label="toggle password visibility"
                        onClick={() => { setValue({ [props.name]: uuid(props.config.formatCode).toUpperCase() }); }}
                        edge="end"
                    >
                        <MaterialIcon icon="Refresh" />
                    </IconButton>
                </InputAdornment>
            }
            disabled
            post={value}
            name={props.name}
            onReview={(value) => { setValue({ [props.name]: value }) }}
        />
    )
}

export default Code
