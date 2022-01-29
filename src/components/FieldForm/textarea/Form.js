import React from 'react'
import { FormControl, makeStyles, FormHelperText, InputLabel, OutlinedInput } from '@material-ui/core';


const useStyles = makeStyles(() => ({
    editor: {
        '&>.MuiInputLabel-outlined.MuiInputLabel-shrink': {
            transform: 'translate(14px, -11px) scale(0.75)'
        },
        '&>.MuiInputBase-root>textarea, &>label': {
            lineHeight: 2.2
        },
        lineHeight: '24px',
    },
}))


export default React.memo(function TextareaForm(props) {

    const { config, post, name, onReview, forceUpdate, ...rest } = props;
    const classes = useStyles()

    const valueInital = post && post[name] ? post[name] : '';
    const [, setRender] = React.useState(0);

    console.log('render TEXTAREA');

    return (

        <FormControl fullWidth variant="outlined">
            {
                Boolean(config.title) ?
                    <>
                        <InputLabel>{config.title}</InputLabel>
                        <OutlinedInput
                            type='textarea'
                            variant="outlined"
                            rows={config.rows ?? 1}
                            name={name}
                            multiline
                            value={valueInital}
                            className={classes.editor}
                            label={config.title}
                            labelWidth={config.title.length * 8}
                            onBlur={e => { onReview(e.target.value, name); setRender(prev => prev + 1); }}
                            onChange={e => { setRender(prev => prev + 1); post[name] = e.target.value }}
                            {...rest}
                        />
                    </>
                    :
                    <OutlinedInput
                        type='textarea'
                        variant="outlined"
                        name={name}
                        rows={config.rows ?? 1}
                        multiline
                        value={valueInital}
                        className={classes.editor}
                        onBlur={e => { onReview(e.target.value, name); setRender(prev => prev + 1); }}
                        onChange={e => { setRender(prev => prev + 1); post[name] = e.target.value }}
                        {...rest}
                    />
            }

            {

                config.maxLength ?
                    <FormHelperText style={{ display: 'flex', justifyContent: 'space-between' }} >
                        {Boolean(config.note) && <span dangerouslySetInnerHTML={{ __html: config.note }}></span>}
                        <span style={{ marginLeft: 24, whiteSpace: 'nowrap' }}>{valueInital.length + '/' + config.maxLength}</span>
                    </FormHelperText>
                    :
                    config.note ?
                        <FormHelperText><span dangerouslySetInnerHTML={{ __html: config.note }}></span></FormHelperText>
                        : null
            }
        </FormControl>
    )
}, (props1, props2) => {

    if (props1.forceUpdate) {
        return false;
    }

    return props1.post[props1.name] === props2.post[props2.name];
})


