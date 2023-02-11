<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class ApiController extends AbstractController {

  #[Route('/class-info/{class_id}', name: 'class_info')]
  public function classInfo(string $class_id) {
    $class_id = mb_strtoupper(preg_replace('/[^A-z0-9]/', '', $class_id));
    $filename = __DIR__ . '/../../data/' . $class_id . '.yml';
    if (file_exists($filename)) {
      try {
        $class_info = Yaml::parseFile($filename);
        return new JsonResponse($class_info);
      }
      catch (ParseException $e) {
        throw new NotFoundHttpException(sprintf('Unable to parse the YAML file: %s', $e->getMessage()));
      }
    }
    throw new NotFoundHttpException(sprintf('Class %s does not exist.', $class_id));
  }

}
