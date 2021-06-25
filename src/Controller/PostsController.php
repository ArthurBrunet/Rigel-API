<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PostsController extends AbstractController
{
    /**
     * @Route("/posts", name="posts")
     *
     * @OA\Get(
     *     path="/posts",
     *     @OA\Response(response="200",
     *                  description="Liste des postes",
     *                  @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Post")))
     * )
     */
    public function getAllPosts(Request $request,PostRepository $postRepository)
    {
        $filter = [];
        $em = $this->getDoctrine()->getManager();
        $metaDatas =$em->getClassMetadata(Post::class)->getFieldNames();
        foreach ($metaDatas as $value) {
            if ($request->query->get($value)) {
                $filter[$value] = $request->query->get($value);
            }
        }
        $posts = $postRepository->findBy($filter);
        $result = [];
        foreach ($posts as $post) {
            $postDTO = new PostDTO();
            $postDTO->setId($post->getId());
            $postDTO->setContent($post->getContent());
            $postDTO->setTitle($post->getTitle());
            $postDTO->setDatePost($post->getDatePost()->format('Y-m-d H:i:s'));
            $postDTO->setMediaUrl($_SERVER['SERVER'].$_SERVER['PATH_IMAGE'].$post->getMedia()->getProviderReference());
            array_push($result,$postDTO);
        }
        $serialize = $this->serializePosts($result);
        $response = new Response();
        $response->setContent(str_replace("\\","",$serialize));
        return $response;
    }

    private function serializePosts($posts) {
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [new JsonEncoder()]);
        return $serializer->serialize($posts, 'json');
    }
}
