<?php
// 进程数量
$workerNum = 4;

for ($i = 0; $i < $workerNum; $i++) {
    // 创建子进程，返回值：父进程=子进程PID，子进程=0，失败=-1
    $pid = pcntl_fork();

    if ($pid == -1) {
        die("fork 创建进程失败\n");
    }

    // 子进程逻辑
    if ($pid == 0) {
        $childPid = posix_getpid();
        echo "【子进程{$childPid}】启动，任务编号：{$i}\n";

        // 模拟业务耗时操作
        $sleepTime = rand(1, 3);
        sleep($sleepTime);
        echo "【子进程{$childPid}】执行完成，耗时{$sleepTime}秒\n";

        // 子进程正常退出，0=成功
        exit($i);
    }
    // 父进程：循环创建，不写业务
}

// 父进程等待所有子进程回收，防止僵尸进程
while (true) {
    // pcntl_wait 阻塞等待任意子进程结束，返回退出子进程PID
    $exitPid = pcntl_wait($status);
    if ($exitPid <= 0) {
        break;
    }
    // 获取子进程退出码
    $exitCode = pcntl_wexitstatus($status);
    echo "【主进程】子进程{$exitPid}已回收，退出码：{$exitCode}\n";
}

echo "【主进程】所有子进程执行完毕，程序退出\n";
