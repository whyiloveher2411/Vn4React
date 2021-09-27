import { Box, Card, CardActions, CardContent, CardHeader } from '@material-ui/core';
import Button from '@material-ui/core/Button';
import Step from '@material-ui/core/Step';
import StepConnector from '@material-ui/core/StepConnector';
import StepLabel from '@material-ui/core/StepLabel';
import Stepper from '@material-ui/core/Stepper';
import { makeStyles, withStyles } from '@material-ui/core/styles';
import Check from '@material-ui/icons/Check';
import DoneRoundedIcon from '@material-ui/icons/DoneRounded';
import SettingsSystemDaydreamRoundedIcon from '@material-ui/icons/SettingsSystemDaydreamRounded';
import StorageRoundedIcon from '@material-ui/icons/StorageRounded';
import SupervisorAccountRoundedIcon from '@material-ui/icons/SupervisorAccountRounded';
import VisibilityRoundedIcon from '@material-ui/icons/VisibilityRounded';
import clsx from 'clsx';
import PropTypes from 'prop-types';
import React from 'react';
import {
  Link, useHistory
} from "react-router-dom";
import { useAjax } from 'utils/useAjax';
import Administrator from './Administrator';
import ConfigDatabase from './ConfigDatabase';
import SystemCheckList from './SystemCheckList';
import ThemeSetting from './ThemeSetting';

const QontoConnector = withStyles({
  alternativeLabel: {
    top: 10,
    left: 'calc(-50% + 16px)',
    right: 'calc(50% + 16px)',
  },
  active: {
    '& $line': {
      borderColor: '#784af4',
    },
  },
  completed: {
    '& $line': {
      borderColor: '#784af4',
    },
  },
  line: {
    borderColor: '#eaeaf0',
    borderTopWidth: 3,
    borderRadius: 1,
  },
})(StepConnector);

const useQontoStepIconStyles = makeStyles({
  root: {
    color: '#eaeaf0',
    display: 'flex',
    height: 22,
    alignItems: 'center',
  },
  active: {
    color: '#784af4',
  },
  circle: {
    width: 8,
    height: 8,
    borderRadius: '50%',
    backgroundColor: 'currentColor',
  },
  completed: {
    color: '#784af4',
    zIndex: 1,
    fontSize: 18,
  },
});

function QontoStepIcon(props) {
  const classes = useQontoStepIconStyles();
  const { active, completed } = props;

  return (
    <div
      className={clsx(classes.root, {
        [classes.active]: active,
      })}
    >
      {completed ? <Check className={classes.completed} /> : <div className={classes.circle} />}
    </div>
  );
}

QontoStepIcon.propTypes = {
  /**
   * Whether this step is active.
   */
  active: PropTypes.bool,
  /**
   * Mark the step as completed. Is passed to child components.
   */
  completed: PropTypes.bool,
};

const ColorlibConnector = withStyles({
  alternativeLabel: {
    top: 22,
  },
  active: {
    '& $line': {
      backgroundImage:
        'linear-gradient( 95deg,rgb(242,113,33) 0%,rgb(233,64,87) 50%,rgb(138,35,135) 100%)',
    },
  },
  completed: {
    '& $line': {
      backgroundImage:
        'linear-gradient( 95deg,rgb(242,113,33) 0%,rgb(233,64,87) 50%,rgb(138,35,135) 100%)',
    },
  },
  line: {
    height: 3,
    border: 0,
    backgroundColor: '#eaeaf0',
    borderRadius: 1,
  },
})(StepConnector);

const useColorlibStepIconStyles = makeStyles({
  root: {
    backgroundColor: '#ccc',
    zIndex: 1,
    color: '#fff',
    width: 50,
    height: 50,
    display: 'flex',
    borderRadius: '50%',
    justifyContent: 'center',
    alignItems: 'center',
  },
  active: {
    backgroundImage:
      'linear-gradient( 136deg, rgb(242,113,33) 0%, rgb(233,64,87) 50%, rgb(138,35,135) 100%)',
    boxShadow: '0 4px 10px 0 rgba(0,0,0,.25)',
  },
  completed: {
    backgroundImage:
      'linear-gradient( 136deg, rgb(242,113,33) 0%, rgb(233,64,87) 50%, rgb(138,35,135) 100%)',
  },
});

function ColorlibStepIcon(props) {
  const classes = useColorlibStepIconStyles();
  const { active, completed } = props;

  const icons = {
    1: <SettingsSystemDaydreamRoundedIcon />,
    2: <StorageRoundedIcon />,
    3: <VisibilityRoundedIcon />,
    4: <SupervisorAccountRoundedIcon />,
    5: <DoneRoundedIcon />,
  };

  return (
    <div
      className={clsx(classes.root, {
        [classes.active]: active,
        [classes.completed]: completed,
      })}
    >
      {icons[String(props.icon)]}
    </div>
  );
}

ColorlibStepIcon.propTypes = {
  /**
   * Whether this step is active.
   */
  active: PropTypes.bool,
  /**
   * Mark the step as completed. Is passed to child components.
   */
  completed: PropTypes.bool,
  /**
   * The label displayed in the step icon.
   */
  icon: PropTypes.node,
};

const useStyles = makeStyles((theme) => ({
  root: {
    width: '100%',
  },
  button: {
    marginRight: theme.spacing(1),
  },
  instructions: {
    marginTop: theme.spacing(1),
    marginBottom: theme.spacing(1),
  },
}));

function getSteps() {
  return ['System Check', 'Database', 'Theme', 'Administrator', 'Finish'];
}

export default function CustomizedSteppers() {

  const { ajax, Loading } = useAjax();

  const classes = useStyles();

  const history = useHistory();

  const [activeStep, setActiveStep] = React.useState(0);

  const [systemCheck, setSystemCheck] = React.useState(false);

  const urlPrefix = process.env.REACT_APP_BASE_URL + 'api/install/admin/';

  const [themeActive, setThemeActive] = React.useState({
    name: '',
    importData: false,
  });

  const [themes, setThemes] = React.useState(false);
  const [administrator, setAdministrator] = React.useState({
    first_name: '',
    last_name: '',
    email_address: '',
    admin_password: '',
    login_url: 'l0gin2222',
    backend_url: 'adm1n2222',
  });

  const [database, setDatabase] = React.useState({
    database_type: 'mysql',
    database_host: 'localhost',
    database_port: 3306,
    database_name: '',
    database_account: '',
    database_password: '',
    table_prefix: 'vn4_'
  });

  const steps = getSteps();

  const handleNext = () => {

    switch (activeStep) {
      case 0:
        let step = activeStep + 1;
        Object.keys(systemCheck).forEach(key => {
          if (!systemCheck[key].result) {
            step = activeStep;
          }
        });
        setActiveStep(step);
        return;
      case 1:
        ajax({
          urlPrefix,
          url: 'database-check',
          method: 'POST',
          data: database,
          success: (result) => {
            if (result.success) {
              setActiveStep(activeStep + 1);
            }
          }
        })
        return;
      case 2:
        ajax({
          urlPrefix,
          url: 'theme-check',
          method: 'POST',
          data: { ...themeActive, ...database, action: 'next' },
          success: (result) => {
            if (result.success) {
              setActiveStep(activeStep + 1);
            }
          }
        })
        return;
      case 3:
        ajax({
          urlPrefix,
          url: 'administrator-check',
          method: 'POST',
          data: administrator,
          success: (result) => {

            if (result.success) {
              setActiveStep(activeStep + 1);
            }
          }
        })
        return;
    }
  };

  const handleBack = () => {
    setActiveStep((prevActiveStep) => prevActiveStep - 1);
  };

  const handleReset = () => {
    setActiveStep(0);
  };

  const getStepContent = (step) => {
    switch (step) {
      case 0:
        return <SystemCheckList checkList={systemCheck} />
      case 1:
        return <ConfigDatabase post={database} onReview={(key, value) => { database[key] = value; }} />;
      case 2:
        return <ThemeSetting data={themes} themeActive={themeActive} setThemeActive={setThemeActive} />;
      case 3:
        return <Administrator post={administrator} onReview={(key, value) => { administrator[key] = value; }} />;
      default:
        return <div style={{ textAlign: 'center' }}><Link variant="contained" color="primary" to={'/dashboard'}>
          <Button variant="contained" color="primary">
            Backend
          </Button>
        </Link></div>;
    }
  };


  React.useEffect(() => {

    switch (activeStep) {
      case 0:
        ajax({
          urlPrefix,
          url: 'system-check',
          method: 'POST',
          success: (result) => {
            setSystemCheck(result.rows);
          },
          error: () => {
            history.push('/dashboard');
          }
        })
        break;
      case 2:
        ajax({
          urlPrefix,
          url: 'theme-check',
          method: 'POST',
          data: { action: 'get' },
          success: (result) => {
            setThemes(result.rows);
          }
        })
        break;
      default:
        break;
    }

  }, [activeStep]);

  return (
    <Box alignItems="center" justifyContent="center" padding={'50px 20px'} style={{ overflowY: 'auto', height: '100vh' }} className="custom_scroll">
      <div style={{ maxWidth: 1040, margin: '0 auto' }}>
        <Card style={{ width: '100%' }}>
          <CardHeader
            title={
              <Stepper alternativeLabel activeStep={activeStep} connector={<ColorlibConnector />}>
                {steps.map((label) => (
                  <Step key={label}>
                    <StepLabel StepIconComponent={ColorlibStepIcon}>{label}</StepLabel>
                  </Step>
                ))}
              </Stepper>
            }
          />
          <CardContent >
            <div className={classes.root}>

              {getStepContent(activeStep)}

            </div>
          </CardContent>
          <CardActions style={{ justifyContent: 'flex-end' }}>
            <div>
              {activeStep === steps.length ? (
                <div>

                  <Button onClick={handleReset} className={classes.button}>
                    Reset
                  </Button>
                </div>
              ) : (
                <div>
                  <div>

                    {
                      activeStep < (steps.length - 1) &&
                      <>
                        <Button disabled={activeStep === 0} onClick={handleBack} className={classes.button}>
                          Back
                        </Button>
                        <Button
                          variant="contained"
                          color="primary"
                          onClick={handleNext}
                          className={classes.button}
                        >
                          Next
                        </Button>
                      </>
                    }
                  </div>
                </div>
              )}
            </div>
          </CardActions>
        </Card>
        {Loading}
      </div>
    </Box>
  );
}
