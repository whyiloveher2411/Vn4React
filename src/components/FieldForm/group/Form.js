import { Card, CardContent, FormControl, FormHelperText, FormLabel, Grid, InputLabel, Table, TableBody, TableCell, TableContainer, TableRow } from '@material-ui/core';
import React from 'react'
import { makeStyles } from '@material-ui/core/styles';
import FieldForm from 'components/FieldForm';

const useStyles = makeStyles((theme) => ({
  root: {
    width: '100%',
  },
  heading: {
    fontSize: theme.typography.pxToRem(15),
  },
  secondaryHeading: {
    fontSize: theme.typography.pxToRem(15),
    color: theme.palette.text.secondary,
  },
  icon: {
    verticalAlign: 'bottom',
    height: 20,
    width: 20,
  },
  dragcontext: {
    marginTop: 8
  },
  details: {
    alignItems: 'center',
  },
  column: {
    flexBasis: '33.33%',
  },
  helper: {
    borderLeft: `2px solid ${theme.palette.divider}`,
    padding: theme.spacing(1, 2),
  },
  link: {
    color: theme.palette.primary.main,
    textDecoration: 'none',
    '&:hover': {
      textDecoration: 'underline',
    },
  },
  padding0: {
    padding: '8px 0 0 0'
  },
  cell: {
    verticalAlign: 'top',
    border: 'none',
  },
  stt: {
    fontWeight: 500
  },
  accordion: {
    '&.Mui-expanded': {
      margin: 0,
    },
    '& $stt': {
      color: '#dedede'
    },
    '&.Mui-disabled $stt': {
      color: '#939393'
    },
  },
  accorDelete: {
    '&>.MuiAccordionSummary-root': {
      background: '#e53935',
    },
    '&>.MuiAccordionSummary-root .MuiTypography-body1': {
      color: 'white',
    },
    '&>.MuiAccordionSummary-root .MuiSvgIcon-root': {
      color: 'white',
    }
  },
  emptyValue: {
    marginTop: 8,
    padding: 16,
    border: '1px dashed #b4b9be',
    cursor: 'pointer',
    borderRadius: 4,
    color: '#555d66'
  }
}));

export default React.memo(function GroupForm(props) {

  const classes = useStyles();

  const { config, post, name, onReview } = props;

  let valueInital = {};

  try {
    if (typeof post[name] === 'object') {
      valueInital = post[name];
    } else {
      if (post[name]) {
        valueInital = JSON.parse(post[name]);
      }
    }

  } catch (error) {
    valueInital = {};
  }

  // console.log(valueInital);

  // if (valueInital && !valueInital[0]) {
  //   valueInital[0] = {
  //     open: true,
  //     confirmDelete: false,
  //     delete: 0,
  //   }
  // }

  post[name] = valueInital;

  let configKey = Object.keys(config.sub_fields);

  const onChangeInputRepeater = (value, key) => {

    try {
      if (typeof post[name] !== 'object') {
        if (post && post[name]) {
          post[name] = JSON.parse(post[name]);
        }
      }
    } catch (error) {
      post[name] = [];
    }



    if (typeof key === 'object' && key !== null) {

      post[name] = {
        ...post[name],
        ...key
      };

    } else {

      post[name] = {
        ...post[name],
        [key]: value
      };
    }

    console.log('onChangeInputGroup', post[name]);
    onReview(post[name]);

  };

  console.log('render GROUP')


  return (
    <FormControl className={classes.root} component="div">
      <FormLabel component="legend">{config.title}</FormLabel>
      {
        Boolean(config.note) &&
        <FormHelperText style={{ marginTop: 5 }} ><span dangerouslySetInnerHTML={{ __html: config.note }}></span></FormHelperText>
      }
      {
        Boolean(post[name]) &&
          config.layout === 'table' ?
          <Grid
            container
            spacing={4}
            style={{ marginTop: 0 }}
          >
            <TableContainer>
              <Table>
                <TableBody>
                  <TableRow>
                    {
                      configKey &&
                      configKey.map(key => {
                        return (
                          <TableCell key={key} className={classes.cell} >
                            <FieldForm
                              compoment={config.sub_fields[key].view ? config.sub_fields[key].view : 'text'}
                              config={config.sub_fields[key]}
                              post={post[name] ?? {}}
                              name={key}
                              onReview={(value, key2 = key) => onChangeInputRepeater(value, key2)}
                            />
                          </TableCell>
                        )
                      })
                    }
                  </TableRow>
                </TableBody>
              </Table>
            </TableContainer>
          </Grid>
          :
          <Grid
            container
            spacing={4}
            style={{ marginTop: 0 }}
          >
            {
              configKey &&
              configKey.map(key => {
                return (
                  <Grid item md={12} xs={12} key={key} >
                    <FieldForm
                      compoment={config.sub_fields[key].view ? config.sub_fields[key].view : 'text'}
                      config={config.sub_fields[key]}
                      post={post[name] ?? {}}
                      name={key}
                      onReview={(value, key2 = key) => onChangeInputRepeater(value, key2)}
                    />
                  </Grid>
                )
              })
            }
          </Grid>
      }
    </FormControl>
  )
}, (props1, props2) => {
  return props1.post[props1.name] === props2.post[props2.name];
})
