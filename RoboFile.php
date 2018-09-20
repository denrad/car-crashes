<?php

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    const ENV_DEV = 'dev';
    const ENV_PROD = 'prod';
    const T = '1';
    const F = '0';

    /**
     * Builds the project.
     *
     * @option $env Build environment ["dev", "prod"].
     * @option $overwrite Whether to overwrite env. dependent files ["1", "0"].
     */
    public function build($options = ['env' => self::ENV_PROD, 'overwrite' => self::T])
    {
        $this->stopOnFail(true);
        $result = $this->collectionBuilder()->addTaskList(
            [
                $this->taskComposerInstallInEnv($options['env'], ['--ignore-platform-reqs']),
                $this->taskYiiInit($options['env'], $options['overwrite']),
                $this->taskYiiCommand('sitemap/index'),
            ]
        )->run();

        if ($result->wasSuccessful()) {
            $this->yell(sprintf('build complete in %.3fs', $result->getExecutionTime()));
        }

        return $result;
    }

    protected function taskYiiCommand($cmd)
    {
        return $this->taskExec("./yii $cmd");
    }

    protected function taskComposerInstallInEnv($env, $args = [])
    {
        if ($env === self::ENV_DEV) {
            return $this->taskComposerInstall()->args($args);
        } elseif ($env === self::ENV_PROD) {
            return $this->taskComposerInstall()->noDev()->optimizeAutoloader()->args($args);
        }
        throw new DomainException("Unknown environment: `$env`");
    }

    protected function taskYiiInit($env, $overwrite)
    {
        $args = [
            'env'       => [self::ENV_DEV => 'Development', self::ENV_PROD => 'Production'],
            'overwrite' => [self::T => 'y', self::F => 'n'],
        ];

        return $this->taskExec('./init')->args(
            '--env=' . $args['env'][$env],
            '--overwrite=' . $args['overwrite'][$overwrite]
        );
    }
}